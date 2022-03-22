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
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'telephone' => 'required',
            'username' => 'required|string',
            'password'=> 'required|min:6',
            'level' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $user = new User();
        $user->nama = $request->nama;
        $user->alamat = $request->alamat;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user->telephone = $request->telephone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = $request->level;

        $user->save();

        $token = JWTAuth::fromUser($user);

        $data = User::where('username','=',$request->username)->first();

        return response()->json([
            'success' => true,
            'message' => 'Register Success',
            'data' => $data
        ]);
    }

    public function index()
    {
        $dt = User::get();
        return response()->json($dt);
    }

    public function show($id)
    {
        $detail = User::where('id',$id)->first();
        return Response()->json($detail);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request -> all(),
        [
            'nama' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required',
            'telephone' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $update=User::where('id', $id)->update([
            'nama' => $request -> nama,
            'alamat' => $request -> alamat,
            'jenis_kelamin' => $request -> jenis_kelamin,
            'telephone' => $request -> telephone, 
        ]);

        if($update){
            $data['status']=true;
            $data['message']="Sukses";
        }else{
            $data['status']=false;
            $data['message']="Gagal";
        }
        return Response()->json($data);
    }
    public function destroy($id)
    {
        $delete = User::where('id',$id)->delete();
        
        if($delete){
            $data['status']=true;
            $data['message']="Sukses";
        }else{
            $data['status']=false;
            $data['message']=['error'=>["Gagal"]];
        }
        return Response()->json($data);
    }
}
