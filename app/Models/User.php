<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function initials(): Attribute
    {
        return Attribute::make(
            get: function () {
                $name = $this->name ?? ''; // Pastikan $name diambil dari model
                $parts = collect(explode(' ', trim($name))) // Hilangkan spasi ekstra
                    ->map(fn ($part) => Str::substr($part, 0, 1))
                    ->filter()
                    ->values(); // Reset indeks numerik

                return $parts->only([0, $parts->count() - 1])->implode('');
            }
        );
    }

    public function animeWatchHistories(): HasMany
    {
        return $this->hasMany(AnimeWatchHistory::class);
    }
}
