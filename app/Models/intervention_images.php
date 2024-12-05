<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention_images extends Model
{
    protected $fillable = [
        'interventionId',
        'imageUrl',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'interventionId');
    }
}
