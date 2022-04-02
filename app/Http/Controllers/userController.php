<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
            'username' => 'required|string',
            'password'=> 'required|min:6',
            'level' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $user = new User();
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

    public function storeMasyarakat(Request $request)
    {
        $validator = Validator::make($request -> all(),
        [
            'username' => 'required|string',
            'password'=> 'required|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->level = 'masyarakat';

        $user->save();

        $token = JWTAuth::fromUser($user);

        $data = User::where('username','=',$request->username)->first();

        return response()->json([
            'success' => true,
            'message' => 'Register Success',
            'data' => $data
        ]);
    }

    public function updateMasyarakat(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'id_masyarakat' => 'required'
        ]);

        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=User::where('id', $id)->update([
            'id_masyarakat' => $request -> id_masyarakat,
        ]);

        if($update){
            $data['success']=true;
            $data['message']="Sukses";
        }else{
            $data['success']=false;
            $data['message']="Gagal";
        }
        return Response()->json($data);
    }

    public function updatePetugas(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        [
            'id_petugas' => 'required'
        ]);

        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=User::where('id', $id)->update([
            'id_petugas' => $request -> id_petugas,
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

    public function index()
    {
        $dt = User::get();
        return response()->json($dt);
    }

    public function onlyPetugas()
    {
        $data = DB::table('users')
                ->select('users.*')
                ->where('users.level','=','petugas')
                ->orWhere('users.level','=','admin')
                ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getallPetugas()
    {
        $data = DB::table('users')
                ->join('petugas','users.id_petugas','=','petugas.id_petugas')
                ->select('users.*','petugas.*')
                ->get();

        return response()->json($data);
    }

    public function getallMasyarakat()
    {
        $data = DB::table('users')
                ->join('masyarakat','users.id_masyarakat','=','masyarakat.id_masyarakat')
                ->select('users.*','masyarakat.*')
                ->get();

        return response()->json($data);
    }

    public function getIdPetugas($id)
    {
        $data = User::where('id','=',$id)->first();
        $data = DB::table('users')
                ->join('petugas','users.id_petugas','=','petugas.id_petugas')
                ->select('users.*','petugas.*')
                ->where('users.id','=',$id)
                ->first();

        return response()->json($data);
    }

    public function getIdMasyarakat($id)
    {
        $data = User::where('id','=',$id)->first();
        $data = DB::table('users')
                ->join('masyarakat','users.id_masyarakat','=','masyarakat.id_masyarakat')
                ->select('users.*','masyarakat.*')
                ->where('users.id','=',$id)
                ->first();

        return response()->json($data);
    }

    public function show($id)
    {
        $detail = User::where('id',$id)->first();
        return Response()->json($detail);
    }

    public function destroy($id)
    {
        $delete = User::where('id',$id)->delete();
        
        if($delete){
            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data user gagal dihapus'
            ]);
        }
    }
}
