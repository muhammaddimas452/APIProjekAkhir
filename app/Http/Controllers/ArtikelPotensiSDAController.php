<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\artikelPotensiSDA;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class ArtikelPotensiSDAController extends Controller
{
    public function index(Request $request)
    {   
        
        $artikel = artikelPotensiSDA::get();
        return response()->json($artikel, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nama_artikel"  => "required",
            "isi_artikel"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
            $image  = $request->file('image');
            $result = CloudinaryStorage::upload($image->getRealPath(), $image->getClientOriginalName());
            $artikel = artikelPotensiSDA::create([
                'nama_artikel' => $request->nama_artikel,
                'isi_artikel' => $request->isi_artikel,
                'image' => $result,
            ]);
            return response()->json([
                "status" => 200,
                "message" => 'Berhasil Menyimpan Data',
            ]);
        }   
    }

    public function show($id)
    {   
        $artikel = artikelPotensiSDA::find($id);
        $baca = artikelPotensiSDA::where('id', $id)->value('views');
        if($artikel){
            $artikeledit = artikelPotensiSDA::where('id', $id)->first();
            $artikeledit->nama_artikel = $artikeledit->nama_artikel;
            $artikeledit->isi_artikel = $artikeledit->isi_artikel;
            $artikeledit->image = $artikeledit->image;
            $artikeledit->views = $baca + 1;
            $artikeledit->save();    
            return response()->json([
                'status'    => 200,
                'artikel'   => $artikel,
                'check'     => $baca 
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Artikel Id Found'
            ]);
        }
    }

    public function edit($id)
    {
        $artikel = artikelPotensiSDA::find($id);
        if($artikel){
            return response()->json([
                'status'    => 200,
                'artikel'   => $artikel
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Artikel Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "nama_artikel"  => "required",
            "isi_artikel"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $artikel = artikelPotensiSDA::find($request->id);
        $file   = $request->file('image');
        if($file == ""){   
            $artikel = artikelPotensiSDA::where('id', $request->id)->first();
            $artikel->nama_artikel = $request->nama_artikel;
            $artikel->isi_artikel = $request->isi_artikel;
            $artikel->tanggal = $request->tanggal;
            if($artikel->save()){
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
            $image = artikel::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $artikel = artikel::where('id', $request->id)->first();
            $artikel->nama_artikel = $request->nama_artikel;
            $artikel->isi_artikel = $request->isi_artikel;
            $artikel->image = $result;
            if($artikel->save()){
                return response()->json([
                    "status" => 200,
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "iya"
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

    public function destroy($id)
    {
        $artikel = artikelPotensiSDA::find($id);

        if($artikel) {  
        $artikel->delete();
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
