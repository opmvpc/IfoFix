<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Device;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdministrationController extends Controller
{
    public function users()
    {
        return Inertia::render('Administration/Users/Index', [
            'users' => fn() => User::all(),

        ]);
    }

    public function clients()
    {
        return Inertia::render('Administration/Clients/Index', [
            'clients' => fn() => Client::all(),

        ]);
    }

    public function devices()
    {
        return Inertia::render('Administration/Devices/Index', [
            'devices' => fn() => Device::all(),
            'brands' => fn() => Brand::all(),
            'types' => fn() => Type::all(),
        ]);
    }
}
