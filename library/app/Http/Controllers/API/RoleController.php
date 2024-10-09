<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;
use App\Http\Requests\roleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        return response()->json([
            "messege" => "Tampil roles berhasil",
            "data" => $roles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Roles::create($request->all());
        return response()->json([
            "messege" => "Tambah Roles Berhasil"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $roles = Roles::find($id);
        if(!$roles){
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }

        return response()->json([
            "messege" => "detail data roles dengan id $id",
            "data" => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $roles = Roles::find($id);
        if(!$roles){
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }
        
        $roles->update($request->all());
        
        return response()->json([
            "messege" => "update roles id $id berhasil",
            
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roles = Roles::find($id);
        if(!$roles){
            return response()->json([
                "messege" => "id tidak ditemukan"
            ], 404);
        }

        $roles->delete();
        return response()->json([
            "messege" => "berhasil menghapus roles id $id"
        ]);
    }
}
