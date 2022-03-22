<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\lelangModel;
use App\Models\barangModel;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use JWTAuth;

class lelangController extends Controller
{
    public $users;

    public function _construct()
    {
        $this -> users = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('lelang')
                ->join('masyarakat','lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','lelang.id_barang','=','barang.id_barang')
                ->join('users','lelang.id_petugas','=','users.id')
                ->select('lelang.*','masyarakat.nama_masyarakat','barang.nama_barang','users.nama')
                ->get();

        return response()->json(['success' => true, 'data' => $data]);
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
            'id_masyarakat' => 'required',
            'harga_akhir' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=lelangModel::create([
            'id_barang' => $request -> id_barang,
            'tgl_lelang' => Carbon::now(),
            'harga_akhir' => $request -> harga_akhir,
            'id_petugas' => $request -> id_petugas,
            'status' => 'berlangsung',  
            'id_masyarakat' => $request -> id_masyarakat
        ]);

        if($create){
            $data['status']=true;
            $data['message']="Sukses";
        }else{
            $data['status']=false;
            $data['message']="Gagal";
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = lelangModel::where('id_lelang','=',$id)->first();
        $data = DB::table('lelang')
                ->join('masyarakat','lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','lelang.id_barang','=','barang.id_barang')
                ->join('users','lelang.id_petugas','=','users.id')
                ->select('lelang.*','masyarakat.nama_masyarakat','barang.nama_barang','users.nama')
                ->where('lelang.id_lelang','=',$id)
                ->first();

        return response()->json($data);
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
            $data['message']="  ";
        }
        return Response()->json($data);
    }

    public function pengajuan(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'id_masyarakat' => 'required',
            'harga_akhir' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=lelangModel::where('id',$id)->update([
            'id_masyarakat' => $request -> id_masyarakat,
            'harga_akhir' => $request -> harga_akhir,
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
        $delete = lelangModel::where('id_lelang',$id)->delete();
        
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