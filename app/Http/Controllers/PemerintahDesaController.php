<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemerintahDesa;
use Illuminate\Support\Facades\Validator;
use App\Models\jabatan;

class PemerintahDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemerintahdesa = PemerintahDesa::with("jabatan")->get();
        $jabatan = jabatan::get();
        return response()->json($pemerintahdesa,200);
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
            "nama"  => "required",
            "jabatan_id"   => "required",
            "gambar_pemerintah" => "required|image",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $pemerintahdesa = new PemerintahDesa;
        $jabatan = new jabatan;
        if($pemerintahdesa){
        $pemerintahdesa->nama = $request->nama;
        $pemerintahdesa->jabatan_id = $request->jabatan_id;
        if($request->hasFile('gambar_pemerintah')){
            $file = $request->file('gambar_pemerintah');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('gambar/', $filename);
            $pemerintahdesa->gambar_pemerintah = 'gambar/'. $filename;
        }
        $pemerintahdesa->save();
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
        $pemerintahdesa = PemerintahDesa::with("jabatan")->find($id);
        if($pemerintahdesa){
            return response()->json([
                'status'    => 200,
                'pemerintahdesa'   => $pemerintahdesa,
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Artikel Id Found'
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
        $pemerintahdesa = PemerintahDesa::find($id);
        if($pemerintahdesa){
            return response()->json([
                'status'    => 200,
                'pemerintahdesa'   => $pemerintahdesa
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Artikel Id Found'
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
            "nama"  => "required",
            "jabatan_id"   => "required",
            "gambar_pemerintah" => "required"
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
            $pemerintahdesa = PemerintahDesa::find($request->id);
            if($pemerintahdesa){
            $pemerintahdesa->nama = $request->nama;
            $pemerintahdesa->jabatan_id = $request->jabatan_id;
            if($request->hasFile('gambar_pemerintah')){
                $file = $request->file('gambar_pemerintah');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.'.$extension;
                $file->move('gambar/', $filename);
                $pemerintahdesa->gambar_pemerintah = 'gambar/'. $filename;
            }
            $pemerintahdesa->save();
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
        $pemerintahdesa = PemerintahDesa::find($id);
        if($pemerintahdesa) {  
        $pemerintah->delete();
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
