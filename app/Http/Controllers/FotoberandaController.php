<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fotoberanda;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;

class FotoberandaController extends Controller
{
    public function index(Request $request)
    {      
        $fotoberanda = fotoberanda::get();
        return response()->json($fotoberanda, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
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
            $fotoberanda = fotoberanda::create([
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
        $fotoberanda = fotoberanda::find($id);
        
        if($fotoberanda){
            $fotoberandaedit = fotoberanda::where('id', $id)->first();
            $fotoberandaedit->image = $fotoberandaedit->image;
            $fotoberandaedit->save();    
            return response()->json([
                'status'    => 200,
                'fotoberanda'   => $fotoberanda,
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No Image Id Found'
            ]);
        }
    }

    public function destroy($id)
    {
        $fotoberanda = fotoberanda::find($id);

        if($fotoberanda) {  
        $fotoberanda->delete();
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
