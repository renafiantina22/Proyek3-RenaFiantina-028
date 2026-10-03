<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public function register(
        Activity $activity,
        array $data
    ): Registration {
        // Rule 1: hanya activity published
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'activity_id' => 'Pendaftaran hanya dapat dilakukan pada kegiatan yang sudah published.',
            ]);
        }

        // Rule 2: start_at belum lewat
        if ($activity->start_at->isPast()) {
            throw ValidationException::withMessages([
                'activity_id' => 'Pendaftaran ditolak karena kegiatan sudah dimulai.',
            ]);
        }

        // Rule 3: email yang sama tidak boleh mendaftar dua kali
        $alreadyRegistered = Registration::where('activity_id', $activity->id)
            ->where('email', $data['email'])
            ->exists();

        if ($alreadyRegistered) {
            throw ValidationException::withMessages([
                'email' => 'Email tersebut sudah terdaftar pada kegiatan ini.',
            ]);
        }

        // Rule 4: kapasitas tidak boleh terlampaui
        if ($activity->registered_count >= $activity->capacity) {
            throw ValidationException::withMessages([
                'activity_id' => 'Kapasitas kegiatan sudah penuh.',
            ]);
        }

        return DB::transaction(function () use ($activity, $data) {
            $registration = Registration::create([
                'activity_id' => $activity->id,
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => $data['registered_at'],
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}