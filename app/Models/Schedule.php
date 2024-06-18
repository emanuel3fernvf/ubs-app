<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'professional_id',
        'patient_id',
        'date',
        'canceled',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
    ];

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class, 'professional_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function getProfessionalNameAttribute(): string
    {
        return $this->professional->name;
    }

    public function getPatientNameAttribute(): string
    {
        return $this->patient->name;
    }
}
