<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class, 'intervention_users', 'user_id', 'interventionId');
    }
}
