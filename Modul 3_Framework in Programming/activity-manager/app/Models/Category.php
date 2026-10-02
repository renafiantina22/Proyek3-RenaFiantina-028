<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Activity;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}