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
        
        $potensi = artikelPotensiSDA::get();
        return response()->json($potensi, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nama_potensi"  => "required",
            "isi_potensi"   => "required",
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
            $potensi = artikelPotensiSDA::create([
                'nama_potensi' => $request->nama_potensi,
                'isi_potensi' => $request->isi_potensi,
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
        $potensi = artikelPotensiSDA::find($id);
        $baca = artikelPotensiSDA::where('id', $id)->value('views');
        if($potensi){
            $potensiedit = artikelPotensiSDA::where('id', $id)->first();
            $potensiedit->nama_potensi = $potensiedit->nama_potensi;
            $potensiedit->isi_potensi = $potensiedit->isi_potensi;
            $potensiedit->image = $potensiedit->image;
            $potensiedit->views = $baca + 1;
            $potensiedit->save();    
            return response()->json([
                'status'    => 200,
                'artikel'   => $potensi,
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
        $potensi = artikelPotensiSDA::find($id);
        if($potensi){
            return response()->json([
                'status'    => 200,
                'artikel'   => $potensi
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
            "nama_potensi"  => "required",
            "isi_potensi"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $potensi = artikelPotensiSDA::find($request->id);
        $file   = $request->file('image');
        if($file == ""){   
            $potensi = artikelPotensiSDA::where('id', $request->id)->first();
            $potensi->nama_potensi = $request->nama_potensi;
            $potensi->isi_potensi = $request->isi_potensi;
            if($potensi->save()){
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
            $image = artikelPotensiSDA::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $potensi = artikelPotensiSDA::where('id', $request->id)->first();
            $potensi->nama_potensi = $request->nama_potensi;
            $potensi->isi_potensi = $request->isi_potensi;
            $potensi->image = $result;
            if($potensi->save()){
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
        $potensi = artikelPotensiSDA::find($id);

        if($potensi) {  
        $potensi->delete();
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
