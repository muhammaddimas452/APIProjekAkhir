<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jumlahpenduduk;
use Illuminate\Support\Facades\Validator;

class JumlahPendudukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jumlahpenduduk = Jumlahpenduduk::value('jumlah_penduduk');
        return response()->json($jumlahpenduduk, 200);
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
        $jumlahpenduduk = new Jumlahpenduduk;
        $jumlahpenduduk->jumlah_penduduk = $request->jumlah_penduduk;
        if($jumlahpenduduk->save()){
            return["status"=>"Berhasil Menyimpan Data"];
        }else{
            return["status"=>"Gagal Menyimpan Data"];
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
        $jumlahpenduduk = Jumlahpenduduk::find($id);
        if(is_null($jumlahpenduduk))
        {
            return response()->json("not found", 404);
        }else{
            return response()->json($jumlahpenduduk ,200);
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
        $jumlahpenduduk = Jumlahpenduduk::find($id);
        if($jumlahpenduduk){
            return response()->json([
                'status'    => 200,
                'jumlahpenduduk'   => $jumlahpenduduk
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'Failed'
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
           "jumlah_penduduk" => "required"
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $jumlahpenduduk = Jumlahpenduduk::find($request->id);

        if($jumlahpenduduk){
        $jumlahpenduduk->jumlah_penduduk = $request->jumlah_penduduk;
        $jumlahpenduduk->save();
        return response()-> json([
                "status" => 200,
                "message" => "Berhasil Edit Data"
            ]);
        }else {
            return response()-> json([
                "status" => 404,
                "message" => "Failed"
                
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
        $jumlahpenduduk = Jumlahpenduduk::find($id);
        if(is_null($jumlahpenduduk))
        {
            return response()->json("data not found", 404);
        }

        $success= $jumlahpenduduk->delete();

        if(!$success)
        {
            return response()->json("Hapus Gagal", 500);
        }else{
            return response()->json("Hapus Berhasil", 201);
        }
    }
}
