<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\masyarakatModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class masyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dt = masyarakatModel::get();
        return response()->json($dt);
    }

    public function maxID($id)
    {
        $data = DB::table('masyarakat')
                ->select('masyarakat.*')
                ->max('id_masyarakat');
                
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //code
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'nama_masyarakat' => 'required',
            'tlp_masyarakat' => 'required',
            'alamat_masyarakat' => 'required',
        ]);

        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $create=masyarakatModel::create([
            'nama_masyarakat' => $request -> nama_masyarakat,
            'tlp_masyarakat' => $request -> tlp_masyarakat,
            'alamat_masyarakat' => $request -> alamat_masyarakat
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
        $detail = masyarakatModel::where('id_masyarakat',$id)->first();
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
        $validator = Validator::make($request->all(),
        [
            'tlp_masyarakat' => 'required',
            'alamat_masyarakat' => 'required',
        ]);

        if($validator->fails()){
            $data['status']=false;
            $data['message']=$validator->errors();
            return response()->json($data);
        }

        $update=masyarakatModel::where('id_masyarakat', $id)->update([
            'tlp_masyarakat' => $req -> tlp_masyarakat,
            'alamat_masyarakat' => $req -> alamat_masyarakat
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
        $delete = masyarakatModel::where('id',$id)->delete();
        
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
