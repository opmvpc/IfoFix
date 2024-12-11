<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Device;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request; // Correction ici : bon import de Request
use Inertia\Inertia;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
            'clients' => Client::all(),
        ]);
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deviceId' => 'required|exists:devices,id',
            'clientId' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Ticket::create([
            ...$validated,
            'isFinished' => false,
            'isDelivered' => false,
            'isDeleted' => false,
        ]);

        return redirect()->back()->with('success', 'Ticket créé avec succès');
    }
}
