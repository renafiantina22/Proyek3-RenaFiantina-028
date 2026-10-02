<?php

namespace App\Services;

use App\Models\Activity;
use DomainException;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const TRANSITIONS = [
        'draft' => ['draft', 'published'],
        'published' => ['published', 'completed'],
        'completed' => ['completed'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $nextStatus = $data['status'] ?? $activity->status;

        $this->ensureValidTransition(
            $activity->status,
            $nextStatus
        );

        $activity->update($data);

        return $activity->refresh();
    }

    private function ensureValidTransition(
        string $current,
        string $next
    ): void {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw new DomainException(
                "Transisi status {$current} ke {$next} tidak diizinkan."
            );
        }
    }

    public function publish(Activity $activity): Activity
    {
        if ($activity->status !== 'draft') {
            throw ValidationException::withMessages([
                'status' => 'Hanya kegiatan draft yang dapat dipublikasikan.',
            ]);
        }

        if (
            ! $activity->category_id ||
            ! $activity->code ||
            ! $activity->title ||
            ! $activity->location ||
            ! $activity->start_at ||
            ! $activity->end_at ||
            ! $activity->capacity
        ) {
            throw ValidationException::withMessages([
                'status' => 'Kegiatan belum lengkap untuk dipublikasikan.',
            ]);
        }

        $activity->update([
            'status' => 'published',
        ]);

        return $activity->refresh();
    }
}
