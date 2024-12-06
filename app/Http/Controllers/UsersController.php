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
        $users = User::all();
        // return $users as JSON
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'firstName' => 'required | string | max:255',
            'lastName' => 'required | string | max:255',
            'email' => 'required| string | email | max:255 | unique:users',
            'password' => $this->passwordRules(),
            'role' => 'required | string | max:255',
        ]);

        // dd($validatedData);
        $user = User::create([
            'firstName' => $validatedData['firstName'],
            'lastName' => $validatedData['lastName'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
        ]);
        // Return Inertia response instead of JSON
        return back()->with('success', 'User created successfully.');
    }
}
