<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    public function index(){
        return response()->json(['data'=>Sensor::all()],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required|max:30',
            'status'    => 'required|boolean'

        ]);
        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],422);
        }

        $sensor = Sensor::create($request->all());
        return response()->json([
            'msg'   =>  "Sensor creado correctamente",
            'data'  =>  $sensor
        ],201);
    }

    public function update(Request $request,int $id){
        $sensor = Sensor::where('id',$id)->first();
        $validate = Validator::make($request->all(),[
            'name'  =>  'required|max:30',
            'status'    => 'required|boolean'
        ]);
        if(!$sensor){
            return response()->json(['msg'=>'Sensor no encontrado'],404);
        }
        if($validate->fails()){
            return response()->json(['errors'=>$validate->errors()],422);
        }
        $sensor->update($request->all());
        return response()->json([
            'msg'   => "Sensor actualizado",
            'data'  =>  $sensor
        ],200);
    }

    public function destroy(int $id){
        $sensor = Sensor::where('id',$id)->first();
        if(!$sensor){
            return response()->json(['msg'=>'Sensor no encontrado'],404);
        }

        $sensor->status = $sensor->status ? false : true;
        $sensor->save();
        if($sensor->status){
            return response()->json([
                'msg'   =>  "Sensor Activado",
                'data'  =>  $sensor
            ],200);
        }
        return response()->json([
            'msg'   =>  "Sensor desactivado",
            'data'  =>  $sensor
        ],200);
        
    }

    public function show(int $id){
        $sensor = Sensor::where('id',$id)->first();
        if(!$sensor){
            return response()->json(['msg'=>'Sensor no encontrado'],404);
        }
        return response()->json(['data'=>$sensor],200);
    }
}
