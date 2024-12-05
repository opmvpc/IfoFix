<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'phone',
        'isDeleted',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'clientId');
    }
}
