<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\bukuRequest;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct(){
        $this->middleware(['auth:api', 'isAdmin']);
    }

    public function index()
    {
        $buku = Buku::all();
        return response()->json([
            "messege" => "Tampikan buku berhasil",
            "data" => $buku
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(bukuRequest $request)
    {
        $data = $request->validated();
        // jika file gambarnya diinput
        if($request->hasFile('poster')) {
            //buat unique name pada gambar yang diinput 
            $posterName = time().'.'.$request->poster->extension();
            //simpan gambar di storage
            $request->poster->storeAs('public/images', $posterName);
            //ganti request nilai request image menjadi $imageName yang baru bukan berdasarkan request
            $path = env('APP_URL').'/storage/images/';
            $data['poster'] = $path.$posterName;
        }
        Buku::create($data);

        return response()->json([
            "messege" => "Tambah buku berhasil",
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::find($id);
        if(!$buku){
            return response()->json([
            "messege" => "BUku id tidak ditemukan",
        ], 404);
        }
        return response()->json([
            "messege" => "Tampikan detail buku berhasil",
            "data" => $buku
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(bukuRequest $request, string $id)
    {
        $data = $request->validated();

        $bukuData = Buku::find($id);

        if(!$bukuData){
            return response()->json([
            "messege" => "Buku id tidak ditemukan",
        ], 404);
        }


        if ($request->hasFile('poster')) {

            // Hapus gambar lama jika ada

            if ($bukuData->poster) {
                $namePoster = basename($bukuData->poster);
                Storage::delete('public/images/' . $namePoster);

            }

            $posterName = time().'.'.$request->poster->extension();

            $request->poster->storeAs('public/images', $posterName);

            $path = env('APP_URL').'/storage/images/';
            $data['poster'] = $path.$posterName;
            

        }

        $bukuData->update($data);

        return response()->json([
            "messege" => "Data berhasil diupdate",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bukuData = Buku::find($id);

        if(!$bukuData){
                return response()->json([
                "messege" => "buku id tidak ditemukan",
            ], 404);
        }

        if ($bukuData->poster) {
                $namePoster = basename($bukuData->poster);
                Storage::delete('public/images/' . $namePoster);

        }

        $bukuData->delete();

        return response()->json([
            "messege" => "Data berhasil didelete",
        ]);
    }
}
