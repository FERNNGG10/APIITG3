<?php

namespace App\Http\Controllers;

use App\Mail\ActiveMail;
use App\Mail\CodeMail;
use App\Models\User;
use App\Rules\EmailRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','active']]);
    }

    public function register(Request $request){

        $validate = Validator::make($request->all(),[

            'name'  =>  'required|max:30',
            'email' => ['required','email','unique:users',new EmailRule],
            'password'  =>  'required|min:8|confirmed'
        ]);
        if($validate->fails()){
            return response()->json(["errors"=>$validate->errors()],422);
        }
        $user=User::create([
            'name'  => $request->name,
            'email' =>  $request->email,
            'password'  =>  Hash::make($request->password),
            'code'  =>  Crypt::encrypt(rand(100000,999999)),
            'rol_id'    => 1
        ]);
        $signed_route = URL::temporarySignedRoute(
            'active',
            now()->addMinutes(15),
            ['user'=>$user->id]
        );
        Mail::to($user->email)->send(new ActiveMail($signed_route,$user->name));
        return response()->json([
            'msg'   =>  "Usuario registrado correctamente, revisa tu correo",
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

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        $user = User::where('email',request('email'))->first();

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        else{
            if($request->has('code')){
                if($this->verify_code($request,$user)){
                    return $this->respondWithToken($token);
                }
                else{
                    return response()->json("Codigo incorrecto",401);
                }
            }
            else{
                $code = Crypt::decrypt($user->code);
                Mail::to($user->email)->send(new CodeMail($code));
                return response()->json(["msg"=>"Ingresa el codigo, revisa tu correo"],200);
            }
        }

        
    }

    public function verify_code(Request $request,User $user){

        $codei = $request->input('code');
        $code = Crypt::decrypt($user->code);
        if($codei == $code){
            $new_code = Crypt::encrypt(rand(100000,999999));
            $user->code = $new_code;
            $user->save();
            return true;
        }
        return false;
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function status()
    {
        return response()->json(auth()->user()->status);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function rolid()
    {
        return response()->json(auth()->user()->rol_id);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
