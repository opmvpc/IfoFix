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
            'activeTab' => $tab,
            'users' => fn() => User::all(),
            'clients' => fn() => Client::all(),
            'flash' => [
                'success' => session('success'),
                'refresh' => session('refresh')
            ]
        ]);
    }
}
