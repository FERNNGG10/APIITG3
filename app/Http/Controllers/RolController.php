<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolController extends Controller
{

public function index()
{
    $roles = Rol::all();
    return response()->json($roles);
}

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'rol' => 'required|string|max:30',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 4422);
    }

    $rol = new Rol();
    $rol->rol = $request->rol;
    $rol->save();

    return response()->json(['message' => 'Rol created successfully', 'data' => $rol], 201);
}

public function show($id)
{
    $rol = Rol::find($id);

    if (!$rol) {
        return response()->json(['message' => 'Rol not found'], 404);
    }

    return response()->json($rol);
}

public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'rol' => 'required|string|max:30',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $rol = Rol::find($id);

    if (!$rol) {
        return response()->json(['message' => 'Rol not found'], 404);
    }

    $rol->rol = $request->rol;
    $rol->save();

    return response()->json(['message' => 'Rol updated successfully', 'data' => $rol], 200);
}

public function destroy($id)
{
    $rol = Rol::find($id);

    if (!$rol) {
        return response()->json(['message' => 'Rol not found'], 404);
    }

    $rol->delete();

    return response()->json(['message' => 'Rol deleted successfully'], 200);
}
}
