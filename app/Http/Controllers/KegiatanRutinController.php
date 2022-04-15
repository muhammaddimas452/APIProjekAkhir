<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kegiatanRutin;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class KegiatanRutinController extends Controller
{
    public function index()
    {
        $kegiatan = kegiatanRutin::all();
        return response()->json($kegiatan, 200);
    }

    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(),[
            "tanggal_kegiatan"  => "required",
            "nama_kegiatan"   => "required",
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
        $kegiatan = kegiatanRutin::create([
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'nama_kegiatan' => $request->nama_kegiatan,
            'image' => $result,
        ]);
        return response()-> json([
            "status" => 200,
            "message" => "Berhasil Tambah Data"
        ]);
        }
    }

    public function show($id)
    {
        $kegiatan = kegiatanRutin::find($id);
        if (is_null($kegiatan)) {
            return response()->json("not found", 404);
        } else {
            return response()->json($kegiatan, 200);
        }
    }

    public function edit($id)
    {
        $kegiatan = kegiatanRutin::find($id);
        if($kegiatan){
            return response()->json([
                'status'    => 200,
                'kegiatan'   => $kegiatan
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Kegiatan Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "tanggal_kegiatan"  => "required",
            "nama_kegiatan"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $kegiatan = kegiatanRutin::find($request->id);
        $file   = $request->file('image');
        if($file == ""){
            $kegiatan = kegiatanRutin::where('id', $request->id)->first();
            $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;
            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            if($kegiatan->save()){
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
            $image = kegiatanRutin::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $kegiatan = kegiatanRutin::where('id', $request->id)->first();
            $kegiatan->tanggal_kegiatan = $request->tanggal_kegiatan;
            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            $kegiatan->image = $result;
            if($kegiatan->save()){
                return response()->json([
                    "status" => 200,
                    "message" => 'Berhasil Menyimpan Data',
                    "foto"  => "Iya"
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
        $kegiatan = kegiatanRutin::find($id);

        if($kegiatan) {  
        $kegiatan->delete();
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
