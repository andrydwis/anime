<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'link_id',
        'ip',
        'referrer',
        'user_agent',
        'country_code',
        'country_name',
        'city',
        'latitude',
        'longitude',
        'utm_source',
        'utm_medium',
        'utm_campaign',
    ];

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
