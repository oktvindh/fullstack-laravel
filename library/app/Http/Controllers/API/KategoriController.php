<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategoris;
use App\Http\Requests\kategoriRequest;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategoris::all();
        return response()->json([
            "message" => "Tampil data kategori berhasil",
            "data" => $kategori
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(kategoriRequest $request)
    {
        Kategoris::create($request->all());
        return response()->json([
            "messege" => "Tambah kategori berhasil"
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategoris::find($id);
        if(!$kategori) {
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }
        return response()->json([
            "message" => "detail data kategori dengan id $id",
            "data" => $kategori
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategoris::find($id);
        if(!$kategori) {
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }

        $kategori->nama = $request->nama;
        $kategori->save();

        return response()->json([
            "messege" => "update kategori berhasil"
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategoris::find($id);
        if(!$kategori) {
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }

        $kategori->delete();
        return response()->json([
            "messege" => "berhasil menghapus kategori dengan id $id"
        ]);
    }
}
