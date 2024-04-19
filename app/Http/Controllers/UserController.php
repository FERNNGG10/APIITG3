<?php

namespace App\Http\Controllers;

use App\Events\UserRolEvent;
use App\Mail\ActiveMail;
use App\Models\User;
use App\Rules\EmailRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(){
        return response()->json(['data' =>  User::all()],200);
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'name'  =>  'required|max:30',
            'email' => ['required','email','unique:users',new EmailRule],
            'password'  =>  'required|min:8|confirmed',
            'status'    =>  'required|boolean',
            'rol_id'    => 'required|exists:roles,id'
        ]);
        if($validate->fails()){
            return response()->json([
                'errors'    =>  $validate->errors()
            ],422);
        }

        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'  =>  Hash::make($request->password),
            'status'    =>  $request->status,
            'code'      =>  Crypt::encrypt(rand(100000,999999)),
            'rol_id'    =>  $request->rol_id
        ]);

        if ($user->status == false){
            $signed_route = URL::temporarySignedRoute(
                'active',
                now()->addMinutes(15),
                ['user'=>$user->id]
            );
            Mail::to($user->email)->send(new ActiveMail($signed_route,$user->name));
        }
       
        return response()->json([
            'msg'   =>  "Usuario creado correctamente",
            'data'  =>  $user
        ],201);
        
      
    }

    public function active(User $user){
        if($user){
            $user->status = true;
            $user->save();
            return response()->json("Usuario activado",200);
        }
        return response()->json("No se encontro usuario",404);
    }

    public function update(Request $request,int $id){
        $user = User::where('id',$id)->first();
        $validate = Validator::make($request->all(),[
            'name'  =>  'required|max:30',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
                new EmailRule
            ],
            'password'  =>  'nullable|min:8',
            'status'    =>  'required|boolean',
            'rol_id'    => 'required|exists:roles,id'
        ]);
        if(!$user){
            return response()->json([
                'msg'   =>  "Usuario no encontrado"
            ],404);
        }
        if($validate->fails()){
            return response()->json([
                'errors'    =>  $validate->errors()
            ],422);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->rol_id = $request->rol_id;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        $data =["user_id"=>$user->id,"rol_id"=>$user->rol_id,"status"=>$user->status];
        event(new UserRolEvent($data));
        return response()->json([
            'msg'   =>  "Usuario actualizado",
            'data'  =>  $user
        ],200);
        
    }

    public function destroy(int $id){
        $user = User::where('id',$id)->first();
        if(!$user){
            return response()->json("No se encontro usuario",404);
        }
        $user->status = $user->status ? false : true;
        $user->save();
        if(!$user->status){
            return response()->json([
                'msg'   =>  "Usuario desactivado",
                'data'  =>  $user
            ]);
        }
        return response()->json([
            'msg'   =>  "Usuario Activado",
            'data'  =>  $user
        ]);
    }

    public function show(int $id){
        $user = User::where('id',$id)->first();
        if(!$user){
            return response()->json([
                'msg'   =>  "Usuario no encontrado"
            ],404);
        }
        return response()->json(['data'=>$user],200);
    }
}
