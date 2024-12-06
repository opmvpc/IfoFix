<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Device;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketsController extends Controller
{
    public function index()
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::with('user')->get(),
            'technicians' => User::where('role', 'technician')->get(),
            'devices' => Device::all(),
            'brands' => Brand::all(),
            'types' => Type::all(),
        ]);
    }
}