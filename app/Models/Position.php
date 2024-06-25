<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'positions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'key',
        'status',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'model_id');
    }

    public function modelPosition(): HasMany
    {
        return $this->hasMany(ModelPosition::class, 'position_id');
    }
}
