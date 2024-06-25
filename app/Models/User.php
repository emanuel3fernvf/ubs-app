<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function getPositionIdAttribute(): int
    {
        $modelPosition = $this->modelPosition()->first();
        if (! $modelPosition) {
            return '';
        }

        return $modelPosition->position_id;
    }

    public function getPositionKeyAttribute(): string
    {
        $modelPosition = $this->modelPosition()->first();
        if (! $modelPosition) {
            return '';
        }

        $position = $modelPosition->position;
        if (! $position) {
            return '';
        }

        return $position->key;
    }

    /**
     * Return related professionals
     */
    public function professional(): HasOne
    {
        return $this->hasOne(Professional::class, 'user_id');
    }

    public function modelPosition(): HasMany
    {
        return $this->hasMany(ModelPosition::class, 'model_id');
    }
}
