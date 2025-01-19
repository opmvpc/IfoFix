<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brandId',
        'typeId',
        'isDeleted'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandId');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'typeId');
    }
}
