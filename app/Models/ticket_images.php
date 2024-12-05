<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket_images extends Model
{
    protected $fillable = [
        'ticketId',
        'imageUrl',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticketId');
    }
}
