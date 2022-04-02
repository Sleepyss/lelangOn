<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\petugasModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class petugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = petugasModel::get();
        return response()->json($dt);
    }

    public function maxID($id)
    {
        $data = DB::table('petugas')
                ->select('petugas.*')
                ->max('id_petugas');
                
        return response()->json($data);
    }


    public function getId()
    {
        $dt = petugasModel::get();
        return response()->json($dt);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nama_petugas' => 'required',
            'tlp_petugas' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required'
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=petugasModel::create([
            'nama_petugas' => $request -> nama_petugas,
            'tlp_petugas' => $request -> tlp_petugas,
            'alamat' => $request -> alamat,
            'jenis_kelamin' => $request -> jenis_kelamin,
        ]);

        if($create){
            $data['status']=true;
            $data['message']="Sukses";
        }else{
            $data['status']=false;
            $data['message']="Gagal";
        }
        return Response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = petugasModel::where('id_petugas',$id)->first();
        return Response()->json($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'nama_petugas' => 'required',
            'tlp_petugas' => 'required',
            'alamat' => 'required',
            'jenis_kelamin' => 'required'
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=petugasModel::where('id_petugas',$id)->update([
            'tlp_petugas' => $request -> tlp_petugas,
            'alamat' => $request -> alamat,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = petugasModel::where('id_petugas',$id)->delete();
        
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
