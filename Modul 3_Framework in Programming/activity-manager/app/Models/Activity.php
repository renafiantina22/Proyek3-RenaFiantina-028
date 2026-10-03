<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Activity extends Model
{
    use SoftDeletes;
    
    public const STATUSES = ['draft', 'published', 'completed'];

    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'category_id',
        'code',
        'start_at',
        'end_at',
        'location',
        'capacity',
        'status',
        'poster_path',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
