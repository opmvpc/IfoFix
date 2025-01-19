<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypesController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Type::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Type créé avec succès')
            ->with('types', Type::all());
    }

    public function update(Request $request, Type $type)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $type->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Type mis à jour avec succès');
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return back()->with('success', 'Type supprimé avec succès')
            ->with('types', Type::all());
    }
}
