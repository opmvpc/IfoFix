<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Inertia\Inertia;

class TicketsController extends Controller
{
    public function index()
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::with('user')->with('device')->get(),
            'technicians' => User::where('role', 'technician')->get(),
            'devices' => Device::all(),
            'brands' => Brand::all(),
            'types' => Type::all(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Tickets/Create', [
            'technicians' => User::where('role', 'technician')->get(),
            'devices' => Device::all(),
            'brands' => Brand::all(),
            'types' => Type::all(),
        ]);
    }
}