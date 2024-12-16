<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

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

        $device = Device::create([
            'name' => $request->name,
            'brandId' => $request->brandId,
            'typeId' => $request->typeId,
        ]);

        return response()->json([
            'message' => 'Device created successfully',
            'device' => $device
        ]);
    }
}
