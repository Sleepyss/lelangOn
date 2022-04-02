<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiModel;
use App\Models\lelangModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use JWTAuth;

class TransaksiController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = TransaksiModel::get();
        return response()->json($dt);
    }

    public function join()
    {
        $data = DB::table('transaksi')
        ->join('lelang', 'transaksi.id_lelang', '=', 'lelang.id_lelang' )
        ->join('masyarakat', 'transaksi.id_masyarakat', '=',  'masyarakat.id_masyarakat')
        ->join('barang', 'transaksi.id_barang', '=', 'barang.id_barang' )
        ->join('petugas', 'transaksi.id_petugas', '=', 'petugas.id_petugas' )
        ->select('transaksi.*', 'lelang.harga_akhir', 'lelang.tgl_lelang', 'masyarakat.nama_masyarakat', 'barang.nama_barang', 'petugas.nama_petugas')
        ->get();

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function joinonly($id)
    {
        $data = DB::table('transaksi')
        ->join('lelang', 'transaksi.id_lelang', '=', 'lelang.id_lelang' )
        ->join('masyarakat', 'transaksi.id_masyarakat', '=',  'masyarakat.id_masyarakat')
        ->join('barang', 'transaksi.id_barang', '=', 'barang.id_barang' )
        ->join('petugas', 'transaksi.id_petugas', '=', 'petugas.id_petugas' )
        ->select('transaksi.*', 'lelang.harga_akhir', 'lelang.tgl_lelang', 'masyarakat.nama_masyarakat','masyarakat.id_masyarakat', 'barang.nama_barang', 'petugas.nama_petugas')
        ->where('transaksi.id_masyarakat','=', $id)
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
            'id_lelang' => 'required',
            'id_petugas' => 'required',
            'id_masyarakat' => 'required',
            'id_barang' => 'required',
            'hargabarang' => 'required',
            
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }


        $create=TransaksiModel::create([
            'id_lelang' => $request -> id_lelang,
            'id_petugas' => $request -> id_petugas,
            'id_masyarakat' => $request -> id_masyarakat,
            'id_barang' => $request -> id_barang,
            'hargabarang' => $request -> hargabarang,
            'tgl_transaksi' => Carbon::now(),
            'pembayaran' => 'belum',
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
        $detail = TransaksiModel::where('id_transaksi',$id)->first();
        return Response()->json($detail);
    }
    public function selectjoin($id)
    {
        $data = TransaksiModel::where('id_transaksi', '=', $id)->first();
        $data = DB::table('transaksi')
        ->join('lelang', 'lelang.id_lelang', '=', 'transaksi.id_lelang')
        ->join('masyarakat', 'masyarakat.id_masyarakat', '=', 'transaksi.id_masyarakat')
        ->join('barang', 'barang.id_barang', '=', 'transaksi.id_barang')
        ->join('petugas', 'petugas.id_petugas', '=', 'transaksi.id_petugas')
        ->select('transaksi.*', 'lelang.harga_akhir', 'lelang.tgl_lelang', 'masyarakat.nama_masyarakat', 'barang.nama_barang', 'barang.deskripsi', 'petugas.nama_petugas')
        ->where('transaksi.id_transaksi', '=', $id)
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
            'hargabarang' => 'required',
            'pembayaran' => 'required'
        ]);
        
        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=TransaksiModel::where('id_transaksi',$id)->update([
            'id_lelang' => $request -> id_lelang,
            'id_petugas' => $request -> id_petugas,
            'id_barang' => $request -> id_barang,
            'id_masyarakat' => $request -> id_masyarakat,
            'hargabarang' => $request -> hargabarang,
            'tgl_transaksi' => $request -> tgl_transaksi,
            'pembayaran' => $request -> pembayaran,  
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

    public function status($id)
    {

        $transaksi = TransaksiModel::where('id_transaksi', '=', $id)->first();
        $transaksi -> pembayaran = 'sudah';
        $transaksi -> save();

        return response() -> json(['message' => 'Status berhasil diubah']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = TransaksiModel::where('id_transaksi',$id)->delete();
        
        if($delete){
            return response()->json([
                'success' => true,
                'message' => 'Data transaksi berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi gagal dihapus'
            ]);
        }
    }

    public function report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required',
            'bulan' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors());
        }

        $tahun = $request->tahun;
        $bulan = $request->bulan;

        $data = DB::table('transaksi')
                ->join('masyarakat', 'transaksi.id_masyarakat','=','masyarakat.id_masyarakat')
                ->join('petugas', 'transaksi.id_petugas','=','petugas.id_petugas')
                ->join('barang', 'barang.id_barang', '=', 'transaksi.id_barang')
                ->select('transaksi.*','masyarakat.nama_masyarakat','petugas.nama_petugas','barang.nama_barang')
                ->whereYear('tgl_transaksi', '=', $tahun)
                ->whereMonth('tgl_transaksi', '=', $bulan)
                ->get();

    return response()->json($data);
    }
}
