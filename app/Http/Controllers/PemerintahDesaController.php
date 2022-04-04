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
            $image  = $request->file('gambar_pemerintah');
            $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
            $pemerintahdesa = PemerintahDesa::create([
                'nama' => $request->nama,
                'jabatan_id' => $request->jabatan_id,
                'gambar_pemerintah' => $result,
            ]);
            return response()-> json([
                "status" => 200,
                "message" => "Berhasil Tambah Data"
            ]);
            
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
        $jabatan = jabatan::find($id);
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
        $file   = $request->file('gambar_pemerintah');
        if($file == ""){
            $pemerintahdesa = PemerintahDesa::where('id', $request->id)->first();
            $pemerintahdesa->nama = $request->nama;
            $pemerintahdesa->jabatan_id = $request->jabatan_id;
            if($pemerintahdesa->save()){
                return response()->json([
                    "status" => 200,
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "tidak"
                ]);
            }else{
                return response()->json([
                    "status" => 404,
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
        }else{
            $image = PemerintahDesa::where('id', $request->id)->value("gambar_pemerintah");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $pemerintahdesa = PemerintahDesa::where('id', $request->id)->first();
            $pemerintahdesa->nama = $request->nama;
            $pemerintahdesa->jabatan_id = $request->jabatan_id;
            $pemerintahdesa->gambar_pemerintah = $result;
            if($pemerintahdesa->save()){
                return response()->json([
                    "status" => 200,
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "tidak"
                ]);
            }else{
                return response()->json([
                    "status" => 404,
                    "message" => 'Gagal Menyimpan Data'
                ]);
            }
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
