<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kegiatan;

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
        $kegiatan = new kegiatan;
        $kegiatan->kegiatan = $request->kegiatan;
        if ($kegiatan->save()) {
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
        return kegiatan::where('kegiatan', $id)->first();
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
        $kegiatan = kegiatan::find($request->id);
        $kegiatan->kegiatan = $request->kegiatan;
        if ($kegiatan->save()) {
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
        $kegiatan = kegiatan::find($id);
        if (is_null($kegiatan)) {
            return response()->json("data not found", 404);
        }

        $success = $kegiatan->delete();

        if (!$success) {
            return response()->json("Hapus Gagal", 500);
        } else {
            return response()->json("Hapus Berhasil", 201);
        }
    }
}
