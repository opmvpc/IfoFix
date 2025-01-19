<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'isDeleted'
    ];

    public function devices()
    {
        return $this->hasMany(Device::class, 'typeId');
    }

    public function brands()
    {
        return $this->hasManyThrough(Brand::class, Device::class, 'typeId', 'id', 'id', 'brandId');
    }
}
