<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{

    use PasswordValidationRules;

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255 | unique:clients',
            'phone' => 'required | string | max:255',
        ]);

        Client::create([
            'firstName' => strtolower($validatedData['firstName']),
            'lastName' => strtolower($validatedData['lastName']),
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        return redirect()->back()->with([
            'success' => 'Client ajouté',
            'refresh' => 'clients'
        ]);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required | integer',
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255',
            'phone' => 'required | string | max:255',
        ]);

        $client = Client::find($validatedData['id']);
        $client->firstName = strtolower($validatedData['firstName']);
        $client->lastName = strtolower($validatedData['lastName']);
        $client->email = $validatedData['email'];
        $client->phone = $validatedData['phone'];
        $client->save();

        return redirect()->back()->with([
            'success' => 'Utilisateur mis à jour',
            'refresh' => 'clients' // Indicateur de refresh
        ]);
    }
}
