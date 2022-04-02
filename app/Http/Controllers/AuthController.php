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
        $credentials = $request->only('username','password');

        try{
            if(!$token = JWTAuth::attempt($credentials)){
                return response()->json(['message' => 'Invalid username and password']);
            }
        }catch(JWTException $e)
        {
            return response()->json(['message' => 'Generate Token Failed']);
        }
        

        $user = JWTAuth::user();

        return response()->json([
            'success' => true,
            'token' => $token,
			'user' => $user,
            'message' => 'Login berhasil',
        ]);
    }

    public function getUser()
    {
        $user = JWTAuth::user();
        return response()->json($user);
    }

    public function loginCheck()
    {
        try
        {
            if(!$user = JWTAuth::parseToken()->authenticate())
            {
                return $this->response->errorResponse([
                    'success' => false,
                    'message' => 'Invalid Token'
                ]);
            }
        }catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e){
            return $this->response->errorResponse([
                'success' => false,
                'message' => 'Token Expired'
            ]);
        }catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return $this->response->errorResponse([
                'success' => false,
                'message' => 'Invalid Token'
            ]);
        }catch (Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Token Absent'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success!'
        ]);
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
