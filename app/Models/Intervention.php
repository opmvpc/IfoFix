<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'duration',
        'date',
        'isFinished',
        'ticketId',
    ];

    protected $casts = [
        'date' => 'date',
        'isFinished' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_interventions', 'interventionId', 'user_id');
    }
}
