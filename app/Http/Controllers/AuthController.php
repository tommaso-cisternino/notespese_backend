<?php

namespace App\Http\Controllers;

 use App\Models\User;
 use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login','register');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt($request->all())){
            return response()->json(["message" => "Unauthorized","us"=>User::all()],401);
        }

        return $this->responseWithJWT($token,auth()->user()->toArray());
    }

    public function register(Request $request){
        $request->validate([
            'email' => 'email|unique:users|required',
            'username' => 'unique:users|required',
            'password' => 'confirmed|required',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json(["user" => $user]);
    }

    public function responseWithJWT($token,array $user = null){
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function refresh(){
        return $this->responseWithJWT(auth()->refresh());
    }

    public function user(){
        return auth()->user();
    }

    public function logout(){
          auth()->logout();
        return response()->json([
            'message' => 'Logged out'
        ],200);
    }
}
