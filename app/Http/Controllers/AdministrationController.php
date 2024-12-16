<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministrationController extends Controller
{
    public function index($tab = 'stats')
    {
        return Inertia::render('Administration/Index', [
            'users' => fn() => User::all(),
            'clients' => fn() => Client::all(),
            'activeTab' => fn() =>  $tab,
            'flash' => [
                'success' => session('success'), // Retrieve flash success message
                'refresh' => session('refresh') // Retrieve refresh flag
            ]
        ]);
    }
}
