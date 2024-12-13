<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Device;
use App\Models\Intervention;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; // Correction ici : bon import de Request
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class TicketsController extends Controller

{
    public function index()
    {
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::where('isDeleted', false)->with([
                'device',
                'interventions.users'
            ])->orderBy('created_at', 'desc')->get(),
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
            'technicianId' => 'nullable|exists:users,id,role,technician'
        ]);

        $ticket = Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deviceId' => $validated['deviceId'],
            'clientId' => $validated['clientId'],
            'user_id' => Auth::id(),
            'isFinished' => false,
            'isDelivered' => false,
            'isDeleted' => false,
        ]);


        if ($request->input(('technicianId')) !== null) {
            //creation d'une intervention
            $Intervention = Intervention::create([
                'ticketId' => $ticket->id,
                'isFinished' => false,
                'isDeleted' => false,
            ]);
            //creation d'un intervention_user
            $Intervention->users()->attach($request->input(('technicianId')));
        }

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
            'interventions' => $ticket->interventions()->with('users')->get(),
            'technicians' => User::where('role', 'technician')->get(),
        ]);
    }
}
