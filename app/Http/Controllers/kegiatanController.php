<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kegiatan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CloudinaryStorage;


class kegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kegiatan = kegiatan::all();
        return response()->json($kegiatan, 200);
    }

    public function paginate(Request $request)
    {
        $request->perpage;
        $kegiatan = kegiatan::orderBy("created_at", "desc")->paginate($request->perpage,[
            'id',
            'tanggal',
            'nama_kegiatan',
            'image',
            'created_at',
            'status'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $kegiatan,
        ]);
    }

    public function kegiatanNot(Request $request)
    {
        $request->perpage;
        $kegiatan = kegiatan::where('status' , 0)->paginate($request->perpage,[
            'id',
            'tanggal',
            'nama_kegiatan',
            'image',
            'created_at',
            'status'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $kegiatan,
        ]);
    }

    public function kegiatanDone(Request $request)
    {
        $request->perpage;
        $kegiatan = kegiatan::where('status' , 1)->paginate($request->perpage,[
            'id',
            'tanggal',
            'nama_kegiatan',
            'image',
            'created_at',
            'status'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $kegiatan,
        ]);
    }

    public function totalDataNot()
    {
        $kegiatan = kegiatan::where('status' , 0)->count();
        return response()->json($kegiatan, 200);
    }
    public function totalDataDone()
    {
        $kegiatan = kegiatan::where('status' , 1)->count();
        return response()->json($kegiatan, 200);
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
        $validator = Validator::make($request->all(),[
            "tanggal"  => "required",
            "nama_kegiatan"   => "required",
            "image"   => "required",
            "status"   => "required"
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
        $kegiatan = kegiatan::create([
            'tanggal' => $request->tanggal,
            'nama_kegiatan' => $request->nama_kegiatan,
            'image' => $result,
            'status' => $request->status,
        ]);
        return response()-> json([
            "status" => 200,
            "message" => "Berhasil Tambah Data"
        ]);
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
        $kegiatan = kegiatan::find($id);
        if (is_null($kegiatan)) {
            return response()->json("not found", 404);
        } else {
            return response()->json($kegiatan, 200);
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
        $kegiatan = kegiatan::find($id);
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
            "tanggal"  => "required",
            "nama_kegiatan"   => "required",
            "image"   => "required",
            "status"   => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $kegiatan = kegiatan::find($request->id);
        $file   = $request->file('image');
        if($file == ""){
            $kegiatan = kegiatan::where('id', $request->id)->first();
            $kegiatan->tanggal = $request->tanggal;
            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            $kegiatan->status = $request->status;
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
            $image = kegiatan::where('id', $request->id)->value("image");
            $result = CloudinaryStorage::replace($image, $file->getRealPath(), $file->getClientOriginalName());
            $kegiatan = kegiatan::where('id', $request->id)->first();
            $kegiatan->tanggal = $request->tanggal;
            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            $kegiatan->image = $result;
            $kegiatan->status = $request->status;
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kegiatan = kegiatan::find($id);

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
