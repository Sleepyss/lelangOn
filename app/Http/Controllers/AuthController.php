<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('name','password');

        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        }catch(JWTException $e)
        {
            return response()->json(['message' => 'could_not _create_token',500]);
        }

        $data = [
            'token' => $token,
            'user' => JWTAuth::user()
        ];

        return response()->json([
            'message' => 'Login Sukses',
            'data' => $data
        ]);
    }

    public function loginCheck()
    {
        try
        {
            if(! $user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['message' => 'Invalid Token']);
            }
        }catch(Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
        {
            return response()->json(['message' => 'Token Expired']);
        }catch(Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['message' => 'Invalid Token']);
        }catch(Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json(['message' => 'Token Absent']);
        }

        return response()->json(['message' => 'Authentication Success!']);
    }

    public function logout()
    {
        if(JWTAuth::Invalidate(JWTAuth::getToken()))
        {
            return response()->json(['message' => 'Anda sudah logout']);
        }else
        {
            return response()->json(['message' => 'Gagal Logout']);
        }
    }
}
