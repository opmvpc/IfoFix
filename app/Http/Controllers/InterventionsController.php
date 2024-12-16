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
            'duration' => 'nullable|integer',
            'date' => 'nullable|date',
            'isFinished' => 'boolean',
            'users' => 'array',
            'users.*' => 'exists:users,id'
        ]);

        // Extraire les users du tableau validé
        $users = $validated['users'] ?? [];
        unset($validated['users']);

        // Mise à jour de l'intervention
        $intervention->update($validated);

        // Synchroniser les utilisateurs
        $intervention->users()->sync(collect($users)->pluck('id'));

        return redirect()->route('interventions.show', $intervention)
            ->with('message', 'Intervention mise à jour avec succès');
    }

    public function create()
    {
        return Inertia::render('Interventions/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string',
            'duration' => 'required|integer',
            'date' => 'required|date',
            'technicianId' => 'required|array', // Changé de technician_ids à technician_id
            'technicianId.*' => 'exists:users,id',
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

        return redirect()->route('interventions.edit', $intervention)
            ->with('message', 'Intervention créée avec succès');
    }
}
