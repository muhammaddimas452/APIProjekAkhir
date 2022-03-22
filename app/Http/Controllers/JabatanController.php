<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jabatan;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = jabatan::all();
        return response()->json($jabatan, 200);
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
            "nama_jabatan"  => "required",
        ]);
        if($validator->fails()){
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $jabatan = new jabatan;
        if($jabatan){
            $jabatan->nama_jabatan = $request->nama_jabatan;
            $jabatan->save(); 
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
        $jabatan = jabatan::find($id);
        if($jabatan){
            return response()->json([
                'status'    => 200,
                'jabatan'   => $jabatan
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No jabatan Id Found'
            ]);
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
        $jabatan = jabatan::find($id);
        if($jabatan){
            return response()->json([
                'status'    => 200,
                'jabatan'   => $jabatan
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No jabatan Id Found'
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
            "nama_jabatan"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $jabatan = jabatan::find($request->id);
        if($jabatan){
            $jabatan->nama_jabatan = $request->nama_jabatan;
            $jabatan->save();
            return response()-> json([
                "status" => 200,
                "message" => "Berhasil Edit Data"
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
        $jabatan = jabatan::find($id);

        if($jabatan) {  
        $jabatan->delete();
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
