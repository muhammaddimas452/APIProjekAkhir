<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\umkm;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class UmkmController extends Controller
{
    public function index(Request $request)
    {   
        
        $umkm = umkm::get();
        return response()->json($umkm, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nama_usaha"  => "required",
            "isi_usaha"   => "required",
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
            $umkm = umkm::create([
                'nama_usaha' => $request->nama_usaha,
                'isi_usaha' => $request->isi_usaha,
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
        $umkm = umkm::find($id);
        $baca = umkm::where('id', $id)->value('views');
        if($umkm){
            $umkmedit = umkm::where('id', $id)->first();
            $umkmedit->nama_usaha = $umkmedit->nama_usaha;
            $umkmedit->isi_usaha = $umkmedit->isi_usaha;
            $umkmedit->image = $umkmedit->image;
            $umkmedit->views = $baca + 1;
            $umkmedit->save();    
            return response()->json([
                'status'    => 200,
                'artikel'   => $umkm,
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
        $umkm = umkm::find($id);
        if($umkm){
            return response()->json([
                'status'    => 200,
                'artikel'   => $umkm
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
            "nama_usaha"  => "required",
            "isi_usaha"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $umkm = umkm::find($request->id);
        $file   = $request->file('image');
        if($file == ""){   
            $umkm = umkm::where('id', $request->id)->first();
            $umkm->nama_usaha = $request->nama_usaha;
            $umkm->isi_usaha = $request->isi_usaha;
            if($umkm->save()){
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
            $image = umkm::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $umkm = umkm::where('id', $request->id)->first();
            $umkm->nama_usaha = $request->nama_usaha;
            $umkm->isi_usaha = $request->isi_usaha;
            $umkm->image = $result;
            if($umkm->save()){
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
        $umkm = umkm::find($id);

        if($umkm) {  
        $umkm->delete();
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
