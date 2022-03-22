<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barangModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class barangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = barangModel::get();
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
            'nama_barang' => 'required',
            'tgl_barang' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=barangModel::create([
            'nama_barang' => $request -> nama_barang,
            'tgl_barang' => $request -> tgl_barang,
            'deskripsi' => $request -> deskripsi,
            'harga' => $request -> harga
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
        $detail = barangModel::where('id_barang',$id)->first();
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
            'nama_barang' => 'required',
            'tgl_barang' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'img_barang' => 'required'
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        // $update=barangModel::where('id_barang',$id)->update([
        //     'nama_barang' => $request -> nama_barang,
        //     'tgl_barang' => $request -> tgl_barang,
        //     'deskripsi' => $request -> deskripsi,
        //     'harga' => $request -> harga,
        //     if($request -> hasfile('img_barang')) {
                
        //     }
        // ]);

        // if($update){
        //     $data['status']=true;
        //     $data['message']="Sukses";
        // }else{
        //     $data['status']=false;
        //     $data['message']="Gagal";
        // }

        $barang = new barangModel();
        $barang -> nama_barang = $request -> nama_barang;
        $barang -> tgl_barang = $request -> tgl_barang;
        $barang -> deskripsi = $request -> deskripsi;
        $barang -> harga = $request -> harga;
        // if($request -> hasfile('img_barang')) {
        //     $file = $request -> file('img_barang');
        //     $extension = $file -> getClientOriginalExtension();
        //     $filename = time().'.'.$extension;
        //     $file->move('uploads/barang/', $filename);
        //     $barang -> img_barang = $filename;
        // }
        $barang -> save();

        $data = barangModel::where('id_barang','=',$barang->id)->first();
        
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
        $hapus = barangModel::where('id_barang',$id)->delete();
        
        if($hapus){
            $data['status']=true;
            $data['message']="Sukses";
        }else{
            $data['status']=false;
            $data['message']=['error'=>["Gagal"]];
        }
        return Response()->json($data);
    }
}
