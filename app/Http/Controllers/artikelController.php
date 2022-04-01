<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\artikel;
use Illuminate\Support\Facades\Validator;

class artikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        
        $artikel = artikel::get();
        return response()->json($artikel, 200);
    }

    public function acak(Request $request)
    {   
        $request->perpage;
        $artikel = artikel::paginate($request->perpage,[
            'nama_artikel',
            'isi_artikel',
            'image',
            'tanggal',
            'views'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $artikel,
        ]);
    }

    public function totalData()
    {
        $artikel = artikel::all()->count();
        return response()->json($artikel, 200);
    }

    public function mostView(Request $request)
    {   
        $request->perpage;
        $artikel = artikel::orderBy("views", "desc")->paginate($request->perpage,[
            'id',
            'nama_artikel',
            'isi_artikel',
            'image',
            'tanggal',
            'views'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $artikel,
        ]);
    }

    public function newest(Request $request)
    {   
        $request->perpage;
        $artikel = artikel::orderBy("created_at", "desc")->paginate($request->perpage,[
            'id',
            'nama_artikel',
            'isi_artikel',
            'image',
            'tanggal',
            'views',
            'created_at'
        ]);;
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $artikel,
        ]);
    }
    
    public function paginate(Request $request)
    {
        $request->perpage;
        $artikel = artikel::paginate($request->perpage,[
            'id',
            'nama_artikel',
            'isi_artikel',
            'image',
            'tanggal',
            'views',
            'updated_at'
        ]);
        return response()->json([
            'perpage' => $request->perpage,
            'data' => $artikel,
        ]);
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
            "nama_artikel"  => "required",
            "isi_artikel"   => "required",
            "image"   => "required|image",
            "tanggal"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $artikel = new artikel;

        if($artikel){
        $artikel->nama_artikel = $request->nama_artikel;
        $artikel->isi_artikel = $request->isi_artikel;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('gambar/', $filename);
            $artikel->image = 'gambar/'. $filename;
        }
        $artikel->tanggal = $request->tanggal;
        $artikel->save();
        return response()-> json([
            "status" => 200,
            "message" => "Berhasil Tambah Data"
        ]);
        }else {
            return response()-> json([
                "status" => 404,
                "message" => "Gagal Tambah Data"
                
            ]);
        }
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
        $artikel = artikel::find($id);
        $baca = artikel::where('id', $id)->value('views');
        if($artikel){
            $artikeledit = artikel::where('id', $id)->first();
            $artikeledit->nama_artikel = $artikeledit->nama_artikel;
            $artikeledit->isi_artikel = $artikeledit->isi_artikel;
            $artikeledit->image = $artikeledit->image;
            $artikeledit->tanggal = $artikeledit->tanggal;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return artikel::where('artikel', $id)->first();
        $artikel = artikel::find($id);
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
            "nama_artikel"  => "required",
            "isi_artikel"   => "required",
            "image"   => "required",
            "tanggal"  => "required",
        ]);
        if($validator->fails())
        {
            return response()->json([
                "status"    => 422,
                "errors"    =>$validator->messages(),
            ]);
        }else{
        $artikel = artikel::find($request->id);

        if($artikel){
        $artikel->nama_artikel = $request->nama_artikel;
        $artikel->isi_artikel = $request->isi_artikel;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() .'.'.$extension;
            $file->move('gambar/', $filename);
            $artikel->image = 'gambar/'. $filename;
        }
        $artikel->tanggal = $request->tanggal;
        $artikel->save();
        return response()-> json([
                "status" => 200,
                "message" => "Berhasil Edit Data"
            ]);
        }else {
            return response()-> json([
                "status" => 404,
                "message" => "Artikel tidak di temukan"
                
            ]);
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
        $artikel = artikel::find($id);

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

    public function search($key)
    {
        return artikel::where('nama_artikel', 'like', "%$key%")->get();
    }
}
