<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\textberanda;
use Illuminate\Support\Facades\Validator;

class TextberandaController extends Controller
{
    public function index()
    {
        $textberanda = textberanda::get();
        return response()->json($textberanda, 200);
    }

    public function edit($id)
    {
        $textberanda = textberanda::find($id);
        if($textberanda){
            return response()->json([
                'status'    => 200,
                'textberanda'   => $textberanda
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No textber$textberanda Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "text_1"  => "required",
            "text_2"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $textberanda = textberanda::find($request->id);

        if($textberanda){
            $textberanda->text_1 = $request->text_1;
            $textberanda->text_2 = $request->text_2;
            $textberanda->save();
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
}
