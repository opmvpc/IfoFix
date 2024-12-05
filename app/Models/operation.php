<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'userId',
        'action',
        'target',
        'targetId',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
