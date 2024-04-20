<?php

namespace App\Http\Controllers;

use App\Events\BombaEvent;
use App\Events\DataSensoEvent;
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
        $lastSensor = SensorMongo::orderBy('_id', 'desc')->first();
        if($lastSensor){
            event(new DataSensoEvent($lastSensor));
        }
        return response()->json(['message' => 'Datos de sensor guardados con éxito', 'data' => $sensor], 201);
    }

    public function last(){
        $lastSensor = SensorMongo::orderBy('_id', 'desc')->first();
        if($lastSensor){
            event(new DataSensoEvent($lastSensor));
            return response()->json(['data' => $lastSensor], 200);
        }
        return response()->json(['error' => "No se encontraron datos"], 404);
       
    }

    public function bomba(){
        $data = true;
        event(new BombaEvent($data));
        //sleep()
        return response()->json(['msg'=>"Se esta regando tu planta",'data'=>$data],200);
    }
}
