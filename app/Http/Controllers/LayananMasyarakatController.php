<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\layananMasyarakat;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class LayananMasyarakatController extends Controller
{
    public function index(Request $request)
    {   
        
        $layanan = layananMasyarakat::get();
        return response()->json($layanan, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "nama_layanan"  => "required",
            "isi_layanan"   => "required",
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
            $layanan = layananMasyarakat::create([
                'nama_layanan' => $request->nama_layanan,
                'isi_layanan' => $request->isi_layanan,
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
        $layanan = layananMasyarakat::find($id);
        $baca = layananMasyarakat::where('id', $id)->value('views');
        if($layanan){
            $layananedit = layananMasyarakat::where('id', $id)->first();
            $layananedit->nama_layanan = $layananedit->nama_layanan;
            $layananedit->isi_layanan = $layananedit->isi_layanan;
            $layananedit->image = $layananedit->image;
            $layananedit->views = $baca + 1;
            $layananedit->save();    
            return response()->json([
                'status'    => 200,
                'layanan'   => $layanan,
                'check'     => $baca 
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No layanan Id Found'
            ]);
        }
    }

    public function edit($id)
    {
        $layanan = layananMasyarakat::find($id);
        if($layanan){
            return response()->json([
                'status'    => 200,
                'layanan'   => $layanan
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No layanan Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "nama_layanan"  => "required",
            "isi_layanan"   => "required",
            "image"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $layanan = layananMasyarakat::find($request->id);
        $file   = $request->file('image');
        if($file == ""){   
            $layanan = layananMasyarakat::where('id', $request->id)->first();
            $layanan->nama_layanan = $request->nama_layanan;
            $layanan->isi_layanan = $request->isi_layanan;
            if($layanan->save()){
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
            $image = layananMasyarakat::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $layanan = layananMasyarakat::where('id', $request->id)->first();
            $layanan->nama_layanan = $request->nama_layanan;
            $layanan->isi_layanan = $request->isi_layanan;
            $layanan->image = $result;
            if($layanan->save()){
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
        $layanan = layananMasyarakat::find($id);

        if($layanan) {  
        $layanan->delete();
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
