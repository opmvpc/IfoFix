<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name',
        'isDeleted'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'deviceId');
    }
}
