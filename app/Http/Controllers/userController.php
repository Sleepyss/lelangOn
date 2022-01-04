<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class userController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request -> all(),
        [
            'name' => 'required|string',
            'password'=> 'required|min:6',
            'level' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;

        $user->save();

        return response()->json(['message' => 'Register Success']);
    }

    public function show()
    {
        $dt = User::get();
        return response()->json($dt);
    }
}
