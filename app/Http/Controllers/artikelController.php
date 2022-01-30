<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\artikel;

class artikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artikel = artikel::all();
        return response()->json($artikel, 200);
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
        $artikel = new artikel;
        $artikel->nama_artikel = $request->nama_artikel;
        $artikel->isi_artikel = $request->isi_artikel;
        if ($artikel->save()) {
            return ["status" => "Berhasil Menyimpan Data"];
        } else {
            return ["status" => "Gagal Menyimpan Data"];
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
        if (is_null($artikel)) {
            return response()->json("not found", 404);
        } else {
            return response()->json($artikel, 200);
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
        return artikel::where('artikel', $id)->first();
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
        $artikel = artikel::find($request->id);
        $artikel->nama_artikel = $request->nama_artikel;
        $artikel->isi_artikel = $request->isi_artikel;
        if ($artikel->save()) {
            return ["status" => "Berhasil menyimpan data"];
        } else {
            return ["status" => "Gagal menyimpan data"];
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
        if (is_null($artikel)) {
            return response()->json("data not found", 404);
        }

        $success = $artikel->delete();

        if (!$success) {
            return response()->json("Hapus Gagal", 500);
        } else {
            return response()->json("Hapus Berhasil", 201);
        }
    }
}
