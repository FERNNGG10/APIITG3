<?php

namespace App\Http\Controllers;

use App\Models\SensorMongo;
use Illuminate\Http\Request;

class MongoController extends Controller
{
    public function index(){
        $sensors = SensorMongo::all();
        return response()->json(['data'=>$sensors],200);
    }

    public function store(Request $request){
       
        $sensorData = $request->all();
        $sensor = SensorMongo::create($sensorData);
        return response()->json(['message' => 'Datos de sensor guardados con éxito', 'data' => $sensor], 201);
    }

    public function last(){
        $lastSensor = SensorMongo::latest()->first();
        return response()->json(['data' => $lastSensor], 200);
    }
}
