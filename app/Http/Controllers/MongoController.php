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

    public function ioslast(){
        $lastSensor = SensorMongo::orderBy('_id', 'desc')->first();
        if($lastSensor){
            return response()->json(['data' => $lastSensor], 200);
        }
        return response()->json(['error' => "No se encontraron datos"], 404);
    }

    public function todos(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            return response()->json(['data'=>$sensorData],200);
        }
        return response()->json(['error'=>"No se encontraron datos",404]);
    }

    
    public function agua(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();

        if($sensorData){
            $aguaData = [];
            foreach ($sensorData as $data) {
                array_push($aguaData, $data->Agua);
            }
            return response()->json(['data' => $aguaData], 200);
        }

        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function temperatura(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $temperaturaData = [];
            foreach($sensorData as $data){
                array_push($temperaturaData,$data->Temperatura);
            }
            return response()->json(['data'=>$temperaturaData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function humedad(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $humedadData = [];
            foreach($sensorData as $data){
                array_push($humedadData,$data->Humedad);
            }
            return response()->json(['data'=>$humedadData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function lluvia(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $lluviaData = [];
            foreach($sensorData as $data){
                array_push($lluviaData,$data->Lluvia);
            }
            return response()->json(['data'=>$lluviaData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function suelo(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $sueloData = [];
            foreach($sensorData as $data){
                array_push($sueloData,$data->Suelo);
            }
            return response()->json(['data'=>$sueloData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function luz(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $luzData = [];
            foreach($sensorData as $data){
                array_push($luzData,$data->Luz);
            }
            return response()->json(['data'=>$luzData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function movimiento(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $movimientoData = [];
            foreach($sensorData as $data){
                array_push($movimientoData,$data->Movimiento);
            }
            return response()->json(['data'=>$movimientoData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }

    public function vibracion(){
        $sensorData = SensorMongo::orderBy('_id','desc')->get();
        if($sensorData){
            $vibracionData = [];
            foreach($sensorData as $data){
                array_push($vibracionData,$data->Vibracion);
            }
            return response()->json(['data'=>$vibracionData],200);
        }
        return response()->json(['error'=>"No se encontraron datos"], 404);
    }


    
}
