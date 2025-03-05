<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'start_date',
        'end_date',
        'is_published',
        'province_id',
        'city_id',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'province_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'city_id');
    }
}
