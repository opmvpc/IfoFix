<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    use PasswordValidationRules;

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255 | unique:users',
            'password' => $this->passwordRules(),
            'role' => 'required | string | max:255',
            'isActive' => 'required | boolean',
        ]);

        User::create([
            'firstName' => strtolower($validatedData['firstName']),
            'lastName' => strtolower($validatedData['lastName']),
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'isActive' => $validatedData['isActive'],
        ]);

        return redirect()->route('administration', ['tab' => 'users'])->with([
            'success' => 'Utilisateur ajouté',
            'refresh' => 'users'
        ]);
    }

    public function edit(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required | integer',
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255',
            'role' => 'required | string | max:255',
            'isActive' => 'required | boolean',
        ]);

        $user = User::find($validatedData['id']);
        $user->firstName = strtolower($validatedData['firstName']);
        $user->lastName = strtolower($validatedData['lastName']);
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->isActive = $validatedData['isActive'];
        $user->save();

        return redirect()->route('administration', ['tab' => 'users'])->with([
            'success' => 'Utilisateur mis à jour',
            'refresh' => 'users' // Indicateur de refresh
        ]);
    }
}
