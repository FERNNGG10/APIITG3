<?php

namespace App\Http\Controllers;

use App\Events\DataSensoEvent;
use App\Models\Plant;
use App\Models\Sensor;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlantController extends Controller
{
 
    public function index(){
        $plants = Plant::where('user_id',auth()->user()->id)->with('sensors')->get()->map(function($plant){
            $sensorNames = $plant->sensors->pluck('name');
            return [
                'id'    =>  $plant->id,
                'plant' =>  $plant->plant,
                'status'    =>  $plant->status,
                'sensors' => $sensorNames

            ];
        });
        
        return response()->json(['data'=>$plants],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'plant' =>  'required|max:30',
            
        ]);
        if($validate->fails()){
            return response()->json([
                'errors'    =>  $validate->errors()
            ],422);
        }
        $plant = Plant::create([
            'plant' =>  $request->plant,
            'user_id'   =>  auth()->user()->id
        ]);
        $sensors = Sensor::all();
        $sensorId = $sensors->pluck('id');
        $plant->sensors()->attach($sensorId);
        
        return response()->json([
            'msg'   =>  "Planta creada",
            'data'  =>  $plant
        ],201); 
                                                                                                
    }

    public function show(int $id){
        $plant = Plant::where('id',$id)->with('sensors')->first();
        if(!$plant){
            return response()->json([
                'msg'=>'Planta no encontrado'
            ],404);
        }
        return response()->json([
            'data'  =>  $plant
        ],200);
    }

    public function update(Request $request,int $id){
        $plant = Plant::where('id',$id)->first();
        $validate = Validator::make($request->all(),[
            'plant' =>  'required|max:30',
            'status'    =>  'required|boolean'
        ]);

        if(!$plant){
            return response()->json([
                'msg'=>'Planta no encontrado'
            ],404);
        }

        if($validate->fails()){
            return response()->json([
                'errors'    =>  $validate->errors()
            ],422);
        }

        $plant->update($request->all());
        return response()->json([
            'msg'   =>  'Planta actualizada correctamente',
            'data'  =>  $plant
        ]);
    }

    public function destroy(int $id){
        $plant = Plant::where('id',$id)->first();
        if(!$plant){
            return response()->json([
                'msg'=>'Planta no encontrado'
            ],404);
        }
        $plant->status = $plant->status ? false : true;
        $plant->save();
        if($plant->status){
            return response()->json([
                'msg'   =>  "Planta Activado",
                'data'  =>  $plant
            ],200);
        }
        return response()->json([
            'msg'   =>  "planta desactivado",
            'data'  =>  $plant
        ],200);

    }

    public function inactivePlants(){
        $plants = Plant::where('user_id',auth()->user()->id)->where('status',0)->with('sensors')->get()->map(function($plant){
            $sensorNames = $plant->sensors->pluck('name');
            return [
                'id'    =>  $plant->id,
                'plant' =>  $plant->plant,
                'status'    =>  $plant->status,
                'sensors' => $sensorNames

            ];
        });
        
        return response()->json(['data'=>$plants],200);
    }


    public function activePlants(){
        $plants = Plant::where('user_id',auth()->user()->id)->where('status',1)->with('sensors')->get()->map(function($plant){
            $sensorNames = $plant->sensors->pluck('name');
            return [
                'id'    =>  $plant->id,
                'plant' =>  $plant->plant,
                'status'    =>  $plant->status,
                'sensors' => $sensorNames

            ];
        });
        
        return response()->json(['data'=>$plants],200);
    }
    



}

