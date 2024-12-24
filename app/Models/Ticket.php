<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'clientId',
        'deviceId',
        'user_id',
        'title',
        'description',
        'isFinished',
        'isChecked',
        'isDelivered',
        'isDeleted',

    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientId');
    }
    public function device()
    {
        return $this->belongsTo(Device::class, 'deviceId');
    }
    public function images()
    {
        return $this->hasMany(Ticket_images::class, 'ticketId');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'ticketId');
    }

    public function technicians()
    {
        return User::query()
            ->join('users_interventions', 'users.id', '=', 'users_interventions.user_id')
            ->join('interventions', 'interventions.id', '=', 'users_interventions.interventionId')
            ->join('tickets', 'tickets.id', '=', 'interventions.ticketId')
            ->where('tickets.id', $this->id) // Filtre pour le ticket actuel
            ->select('users.*');
    }
}
