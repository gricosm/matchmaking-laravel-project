<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator -> fails()){
            return $this -> errorResponse('Validation Error -> ' . $validator -> errors() -> __toString());
        }

        $user = User::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request -> password)
        ]);

        $token = $user -> createToken('auth_token') -> plainTextToken;

        return response() -> json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request -> only('email', 'password')))
        {
            return $this -> errorResponse(['message' => 'Error en el Login'], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request['email']) -> firstOrFail();

        $token = $user -> createToken('auth_token') -> plainTextToken;

        return response() -> json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request -> user() -> currentAccessToken() -> delete();
        return $this -> successResponse(['message' => 'Tokens Revoked'], Response::HTTP_ACCEPTED);
    }
}
