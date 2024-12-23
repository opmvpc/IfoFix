<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class InterventionsController extends Controller
{
    public function edit(Intervention $intervention)
    {

        $intervention->load('users');

        return Inertia::render('Interventions/Edit', [
            'intervention' => $intervention,
            'interventionImage' => $intervention->images(),
            'allUsers' => User::all(['id', 'firstName', 'lastName'])->toArray()
        ]);
    }

    public function show(Intervention $intervention)
    {

        $intervention->load('users');

        return Inertia::render('Interventions/Show', [
            'intervention' => $intervention,
            'interventionImage' => $intervention->images(),
            'allUsers' => User::all(['id', 'firstName', 'lastName'])->toArray()
        ]);
    }

    public function update(Request $request, Intervention $intervention)
    {

        $validated = $request->validate([
            'description' => 'nullable|string',
            'duration' => 'nullable|date_format:H:i',
            'date' => 'nullable|date',
            'isFinished' => 'boolean',
            'users' => 'array',
            'users.*.id' => 'exists:users,id' // Modification ici pour valider les IDs dans le tableau d'objets users
        ]);

        // Extraire les IDs des users du tableau validé
        $userIds = collect($validated['users'])->pluck('id')->toArray();
        unset($validated['users']);

        // Mise à jour de l'intervention
        $intervention->update($validated);

        // Synchroniser les utilisateurs avec les IDs
        $intervention->users()->sync($userIds);

        $ticket = $intervention->ticket;

        // cloture the ticket if one of the interventions is finished
        if ($intervention->isFinished) {
            $ticket->update(['isFinished' => true]);
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('message', 'Intervention mise à jour avec succès');
    }

    public function create()
    {
        return Inertia::render('Interventions/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'description' => 'required|string',
            // 'duration' => 'required|integer',
            // 'date' => 'required|date',

            // 'technicianId' => 'required|array',
            // 'technicianId.*' => 'exists:users,id',

            'technicianId' => 'required|array|exists:users,id',
            'ticketId' => 'required|exists:tickets,id'
        ]);

        // Extraire les technician_ids avant la création
        $technicianIds = $validated['technicianId']; // Changé de technician_ids à technician_id
        unset($validated['technicianId']);

        $intervention = Intervention::create($validated);

        // Attacher les techniciens à l'intervention
        $intervention->users()->attach($technicianIds);

        if ($request->wantsJson()) {
            return response()->json(['intervention' => $intervention]);
        }

        return redirect()->route('tickets.show', $validated['ticketId'])
            ->with('message', 'Intervention créée avec succès');
    }
}
