<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

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
