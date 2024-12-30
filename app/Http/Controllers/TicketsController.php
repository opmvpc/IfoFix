<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Client;
use App\Models\Device;
use App\Models\Intervention;
use App\Models\Ticket;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function create()
    {
        return Inertia::render('Tickets/Create', [
            'devices' => Device::all(),
            'brands' => Brand::all(),
            'types' => Type::all(),
            'clients' => Client::all(),
            'technicians' => User::where('role', 'technician')->get(),
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deviceId' => 'required|exists:devices,id',
            'clientId' => 'required|exists:clients,id',
            'technicianIds' => 'nullable|array|exists:users,id,role,technician',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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

        // Gestion des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ticket-images', 'public');
                $ticket->images()->create([
                    'imageUrl' => $path,
                ]);
            }
        }

        if ($request->input(('technicianIds')) !== null) {
            //creation d'une intervention
            $Intervention = Intervention::create([
                'ticketId' => $ticket->id,
                'isFinished' => false,
                'isDeleted' => false,
            ]);
            //creation d'un intervention_user
            $Intervention->users()->attach($request->input(('technicianIds')));
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
            'ticket' => $ticket->load(['user', 'device.brand', 'device.type', 'client', 'images']),
            'devices' => Device::all(),
            'brands' => Brand::all(),
            'types' => Type::all(),
            'clients' => Client::all(),
            'interventions' => $ticket->interventions()->with('users')->orderBy('created_at', 'desc')->get(),
            'technicians' => User::where('role', 'technician')->get(),
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deviceId' => 'required|exists:devices,id',
            'clientId' => 'required|exists:clients,id',
            'technicianIds' => 'nullable|array|exists:users,id,role,technician',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Mise à jour des informations de base du ticket
        $ticket->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'deviceId' => $validated['deviceId'],
            'clientId' => $validated['clientId'],
        ]);

        // Gestion des nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ticket-images', 'public');
                $ticket->images()->create([
                    'imageUrl' => $path,
                ]);
            }
        }

        // Gestion des techniciens
        if ($request->has('technicianIds')) {
            // Récupérer l'intervention existante ou en créer une nouvelle
            $intervention = $ticket->interventions()->first() ?? Intervention::create([
                'ticketId' => $ticket->id,
                'isFinished' => false,
                'isDeleted' => false,
            ]);

            // Mettre à jour les techniciens assignés
            $intervention->users()->sync($request->input('technicianIds'));
        }

        return redirect()->back()->with('success', 'Ticket mis à jour avec succès');
    }
}
