<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\berita;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;


class BeritaController extends Controller
{
    public function index(Request $request)
    {   
        
        $berita = berita::get();
        return response()->json($berita, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nama_berita"  => "required",
            "isi_berita"   => "required",
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
            $berita = berita::create([
                'nama_berita' => $request->nama_berita,
                'isi_berita' => $request->isi_berita,
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
        $berita = berita::find($id);
        $baca = berita::where('id', $id)->value('views');
        if($berita){
            $beritaedit = berita::where('id', $id)->first();
            $beritaedit->nama_berita = $beritaedit->nama_berita;
            $beritaedit->isi_berita = $beritaedit->isi_berita;
            $beritaedit->image = $beritaedit->image;
            $beritaedit->views = $baca + 1;
            $beritaedit->save();    
            return response()->json([
                'status'    => 200,
                'berita'   => $berita,
                'check'     => $baca 
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No berita Id Found'
            ]);
        }
    }

    public function edit($id)
    {
        $berita = berita::find($id);
        if($berita){
            return response()->json([
                'status'    => 200,
                'berita'   => $berita
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No berita Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "nama_berita"  => "required",
            "isi_berita"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $berita = berita::find($request->id);
        $file   = $request->file('image');
        if($file == ""){   
            $berita = berita::where('id', $request->id)->first();
            $berita->nama_berita = $request->nama_berita;
            $berita->isi_berita = $request->isi_berita;
            if($berita->save()){
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
            $image = berita::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $berita = berita::where('id', $request->id)->first();
            $berita->nama_berita = $request->nama_berita;
            $berita->isi_berita = $request->isi_berita;
            $berita->image = $result;
            if($berita->save()){
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
        $berita = berita::find($id);

        if($berita) {  
        $berita->delete();
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
