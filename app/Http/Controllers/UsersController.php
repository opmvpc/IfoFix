<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{

    use PasswordValidationRules;

    public function index()
    {
        // $status = $request->query('status', 'all');

        // $query = User::all();

        // if ($status !== 'all') {
        //     $query->where('isActive', $status === 'active');
        // }

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
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'isActive' => $validatedData['isActive'],
        ]);
        // Return Inertia response instead of JSON
        return back()->with([
            'success' => 'Utilisateur Créer',
            'refresh' => true // Indicateur de refresh
        ]);
    }

    public function edit(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'id' => 'required | integer',
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255',
            'role' => 'required | string | max:255',
            'isActive' => 'required | boolean',
        ]);

        $user = User::find($validatedData['id']);
        $user->firstName = $validatedData['firstName'];
        $user->lastName = $validatedData['lastName'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];
        $user->isActive = $validatedData['isActive'];
        $user->save();

        return back()->with([
            'success' => 'Utilisateur mis à jour',
            'refresh' => true // Indicateur de refresh
        ]);
    }
}
