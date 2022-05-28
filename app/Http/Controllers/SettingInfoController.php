<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\settingInfo;
use Illuminate\Support\Facades\Validator;

class SettingInfoController extends Controller
{
    public function index()
    {
        $info = settingInfo::get();
        return response()->json($info, 200);
    }

    public function edit($id)
    {
        $info = settingInfo::find($id);
        if($info){
            return response()->json([
                'status'    => 200,
                'info'   => $info
            ]);
        }else{
            return response()->json([
                'status'    => 404,
                'message'   =>'No info Id Found'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "lokasi_desa"  => "required",
            "email_desa"   => "required",
            "nomor_hp1"   => "required",
            "nomor_hp2"  => "required",
            "link_fb"  => "required",
            "link_twitter"  => "required",
            "link_ig"  => "required",
            "link_yt"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $info = settingInfo::find($request->id);

        if($info){
            $info->lokasi_desa = $request->lokasi_desa;
            $info->email_desa = $request->email_desa;
            $info->nomor_hp1 = $request->nomor_hp1;
            $info->nomor_hp2 = $request->nomor_hp2;
            $info->link_fb = $request->link_fb;
            $info->link_twitter = $request->link_twitter;
            $info->link_ig = $request->link_ig;
            $info->link_yt = $request->link_yt;
            $info->save();
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
