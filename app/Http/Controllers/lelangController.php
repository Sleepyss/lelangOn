<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lelangModel;
use App\Models\barangModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class lelangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = lelangModel::get();
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
            'id_barang' => 'required',
            'id_petugas' => 'required',
            'id_masyarakat' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=lelangModel::create([
            'id_barang' => $request -> id_barang,
            'tgl_lelang' => Carbon::now(),
            $barang = barangModel::where('id_barang','=', $request->id_barang)->first(),
            'harga_akhir' => $barang -> harga,
            'id_petugas' => $request -> id_petugas,
            'status' => 'berlangsung',
            'id_masyarakat' => $request -> id_masyarakat,  
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
        $detail = lelangModel::where('id',$id)->first();
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
            'id_barang' => 'required',
            'tgl_lelang' => 'required',
            'harga_akhir' => 'required',
            'id_petugas' => 'required',
            'status' => 'required',
            'id_masyarakat' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=lelangModel::where('id',$id)->update([
            'id_barang' => $request -> id_barang,
            'tgl_lelang' => $request -> tgl_lelang,
            'harga_akhir' => $request -> harga_akhir,
            'id_petugas' => $request -> id_petugas,
            'status' => $request -> status,
            'id_masyarakat' => $request -> id_masyarakat,  
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
        $delete = lelangModel::where('id',$id)->delete();
        
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