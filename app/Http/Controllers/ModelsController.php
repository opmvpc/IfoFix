<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModelsController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brandId' => 'required|exists:brands,id',
            'typeId' => 'required|exists:types,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Device::create([
            'name' => $request->name,
            'brandId' => $request->brandId,
            'typeId' => $request->typeId,
        ]);

        return back()->with('success', 'Modèle créé avec succès')
            ->with('devices', Device::all());
    }

    public function update(Request $request, Device $device)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'brandId' => 'required|exists:brands,id',
            'typeId' => 'required|exists:types,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $device->update([
            'name' => $request->name,
            'brandId' => $request->brandId,
            'typeId' => $request->typeId,
        ]);

        return back()->with('success', 'Modèle mis à jour avec succès');
    }

    public function destroy(Device $device)
    {
        $device->delete();
        return back()->with('success', 'Modèle supprimé avec succès')
            ->with('devices', Device::all());
    }
}
