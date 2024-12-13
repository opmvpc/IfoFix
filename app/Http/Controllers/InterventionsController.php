<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InterventionsController extends Controller
{
    //

    public function show(Intervention $intervention)
    {


        return Inertia::render('Interventions/Show', [
            'intervention' => $intervention->with('users')->get(),
        ]);
    }
}
