<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hlelangModel;
use App\Models\lelangModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HlelangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = hlelangModel::get();
        return response()->json($dt);
    }

    public function getAll()
    {
        $data = DB::table('history_lelang')
                ->join('masyarakat','history_lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','history_lelang.id_barang','=','barang.id_barang')
                ->join('lelang','history_lelang.id_lelang','=','lelang.id_lelang')
                ->select('history_lelang.*','masyarakat.nama_masyarakat')
                ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getId($id)
    {
        $data = DB::table('history_lelang')
                ->join('masyarakat','history_lelang.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('barang','history_lelang.id_barang','=','barang.id_barang')
                ->join('lelang','history_lelang.id_lelang','=','lelang.id_lelang')
                ->select('history_lelang.*','masyarakat.nama_masyarakat')
                ->where('history_lelang.id_lelang', '=', $id)
                ->get();

        return response()->json($data);
    }

    public function maxPenawaran($id)
    {
        $data = DB::table('history_lelang')
                ->select('history_lelang.*')
                ->where('history_lelang.id_lelang','=',$id)
                ->max('history_lelang.penawaran_harga');
                
        return response()->json($data);
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
            'id_lelang' => 'required',
            'id_barang' => 'required',
            'id_masyarakat' => 'required',
            'penawaran_harga' => 'required',
        ]); 
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=hlelangModel::create([
            'id_lelang' => $request -> id_lelang,
            'id_barang' => $request -> id_barang,
            'id_masyarakat' => $request -> id_masyarakat,
            'penawaran_harga' => $request -> penawaran_harga,  
        ]);

        if($create){
            $data['success']=true;
            $data['message']="Sukses";
        }else{
            $data['success']=false;
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
        $detail = hlelangModel::where('id',$id)->first();
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
            'id_lelang' => 'required',
            'id_barang' => 'required',
            'id_masyarakat' => 'required',
            'penawaran_harga' => 'required',
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=hlelangModel::where('id',$id)->update([
            'id_lelang' => $request -> id_lelang,
            'id_barang' => $request -> id_barang,
            'id_masyarakat' => $request -> id_masyarakat,
            'penawaran_harga' => $request -> penawaran_harga,  
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
        $delete = hlelangModel::where('id',$id)->delete();
        
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
