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
        'userId',
        'title',
        'description',
        'isFinished',
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
}
