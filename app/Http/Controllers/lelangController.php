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
                ->leftjoin('masyarakat','lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','lelang.id_barang','=','barang.id_barang')
                ->join('petugas','lelang.id_petugas','=','petugas.id_petugas')
                ->select('lelang.*','masyarakat.nama_masyarakat','barang.nama_barang','petugas.nama_petugas')
                ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function available()
    {
        $data = DB::table('lelang')
                ->leftjoin('masyarakat','lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','lelang.id_barang','=','barang.id_barang')
                ->join('petugas','lelang.id_petugas','=','petugas.id_petugas')
                ->select('lelang.*','masyarakat.nama_masyarakat','barang.nama_barang','petugas.nama_petugas')
                ->where('lelang.status','=','berlangsung')
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
            'harga_akhir' => 'required',
            'id_petugas' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=lelangModel::create([
            'id_barang' => $request -> id_barang,
            'harga_akhir' => $request -> harga_akhir,
            'tgl_lelang' => Carbon::now(),
            'id_petugas' => $request -> id_petugas,
            'status' => 'berlangsung',  
        ]);

        if($create){
            $data['success']=true;
            $data['message']="Sukses";
        }else{
            $data['success']=false;
            $data['message']="Gagal";
        }
        return response()->json($data);
    }

    public function updateHargaMasyarakat(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'harga_akhir' => 'required',
            'id_masyarakat' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=lelangModel::where('id_lelang',$id)->update([
            'harga_akhir' => $request -> harga_akhir,
            'id_masyarakat' => $request -> id_masyarakat  
        ]);

        if($update){
            $data['success']=true;
            $data['message']="Sukses";
        }else{
            $data['success']=false;
            $data['message']="Failed";
        }
        return Response()->json($data);
    }

    public function changeStatus(Request $request, $id)
    {

        $lelang = lelangModel::where('id_lelang', '=', $id)->first();
        $lelang -> status = 'berhenti';
        $lelang -> save();

        return response() -> json(['message' => 'Status berhasil diubah']);

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
                ->leftjoin('masyarakat','lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','lelang.id_barang','=','barang.id_barang')
                ->join('petugas','lelang.id_petugas','=','petugas.id_petugas')
                ->select('lelang.*','masyarakat.nama_masyarakat','barang.nama_barang','petugas.nama_petugas')
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
            $data['success']=true;
            $data['message']="Sukses";
        }else{
            $data['success']=false;
            $data['message']="gagal";
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

    public function Tutup($id)
    {
        
    }
}