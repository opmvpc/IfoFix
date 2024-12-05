<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention_images extends Model
{
    use HasFactory;
    protected $fillable = [
        'interventionId',
        'imageUrl',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'interventionId');
    }
}
