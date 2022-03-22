<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoWilayah;
use Illuminate\Support\Facades\Validator;

class InfoWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infowilayah = InfoWilayah::all();
        return response()->json($infowilayah, 200);
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
            "nama_desa"  => "required",
            "rt"   => "required",
            "rw"   => "required",
            "kepala_desa"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $infowilayah = new InfoWilayah;

        if($infowilayah){
        $infowilayah->nama_desa = $request->nama_desa;
        $infowilayah->rt = $request->rt;
        $infowilayah->rw = $request->rw;
        $infowilayah->kepala_desa = $request->kepala_desa;
        $infowilayah->save();
        return response()-> json([
            "status" => 200,
            "message" => "Berhasil Tambah Data"
        ]);
        }else {
            return response()-> json([
                "status" => 404,
                "message" => "Gagal Tambah Data"
                
            ]);
        }
        }
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infowilayah = InfoWilayah::find($id);
        if (is_null($infowilayah)) {
            return response()->json("not found", 404);
        } else {
            return response()->json($infowilayah, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infowilayah = InfoWilayah::find($id);
        if($infowilayah){
            return response()->json([
                'status'    => 200,
                'infowilayah'   => $infowilayah
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No infowilayah Id Found'
            ]);
        }
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
            "nama_desa"  => "required",
            "rt"   => "required",
            "rw"   => "required",
            "kepala_desa"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $infowilayah = InfoWilayah::find($request->id);

        if($infowilayah){
            $infowilayah->nama_desa = $request->nama_desa;
            $infowilayah->rt = $request->rt;
            $infowilayah->rw = $request->rw;
            $infowilayah->kepala_desa = $request->kepala_desa;
            $infowilayah->save();
            return response()-> json([
                "status" => 200,
                "message" => "Berhasil Update Data"
            ]);
            }else {
                return response()-> json([
                    "status" => 404,
                    "message" => "Gagal Update Data"
                    
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $infowilayah = InfoWilayah::find($id);

        if($infowilayah) {  
        $infowilayah->delete();
            return response()->json([
                "message" => "Hapus Berhasil", 
                'status'=> 200
            ]);
        } else {
            return response()->json([
                "message" => "Hapus Gagal", 
                'status'=> 500
            ]);
        }
    }
}
