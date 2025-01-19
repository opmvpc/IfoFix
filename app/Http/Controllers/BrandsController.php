<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        Brand::create([
            'name' => $request->name,
        ]);

        return back()->with('message', 'Marque créée avec succès')
            ->with('brands', Brand::all());
    }

    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors());
        }

        $brand->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Marque mise à jour avec succès');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with('success', 'Marque supprimée avec succès')
            ->with('brands', Brand::all());
    }
}
