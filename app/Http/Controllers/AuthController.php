<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login', 'register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt($request->all())) {
            return response()->json(["message" => "Unauthorized", "user" => auth()->user()], 401);
        }

        return $this->responseWithJWT($token, auth()->user()->toArray());
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'email|unique:users|required',
            'username' => 'unique:users|required',
            "password" =>
                'min:8|required_with:password_confirmation|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%.#%^€<>£*?&])[A-Za-z\d@$!%*?.#%^€<>£&]{8,}$/',
            "password_confirmation" =>
                "required|min:8|same:password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%.#%^€<>£*?&])[A-Za-z\d@$!%*?.#%^€<>£&]{8,}$/",
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        try {
            $user->save();
        }catch (\Exception $exception){
            return response()->json(["user" => null,"token" => null,"error" => $exception->getMessage()],500);
        }

        return response()->json(["user" => $user],201);
    }

    public function responseWithJWT($token, array $user = null)
    {
        return response()->json([
            'access_token' => $token,
            'type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function refresh()
    {
        return $this->responseWithJWT(auth()->refresh());
    }

    public function user()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'message' => 'Logged out'
        ], 200);
    }
}
