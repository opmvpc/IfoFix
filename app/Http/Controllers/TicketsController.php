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
            'tickets' => Ticket::where('isDeleted', false)->with('user')->with('device')->get(),
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
            'user_id' => 'nullable|exists:users,id',
        ]);

        Ticket::create([
            ...$validated,
            'isFinished' => false,
            'isDelivered' => false,
            'isDeleted' => false,
        ]);

        return redirect()->back()->with('success', 'Ticket créé avec succès');
    }

    //delete function
    public function destroy(Ticket $ticket)
    {
        //soft delete
        $ticket->update([
            'isDeleted' => true,
        ]);
        return redirect()->back()->with('success', 'Ticket supprimé avec succès');
    }

    public function show(Ticket $ticket)
    {
        return Inertia::render('Tickets/ShowTicket', [
            'ticket' => $ticket->load(['user', 'device', 'client']),
        ]);
    }
}
