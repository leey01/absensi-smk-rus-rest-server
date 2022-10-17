<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\role;
use App\Models\TrxAbsensi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $roles = role::all();

        return response()->json([
            'message' => 'All data Roles',
            'data' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'nama_role' => ['required'],
            'power' => ['required'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $absensi = role::create([
                'nama_role' => $request->nama_role,
                'power' => $request->power,
            ]);

            $response = [
                'status' => 'success',
                'message' => 'Role baru berhasil dibuat',
                'data' => $absensi
            ];

            return response()->json($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $role = role::find($id);

        $validator = Validator::make(request()->all(), [
            'nama_role_baru' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $role->update([
                'nama_role' => $request->nama_role_baru
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Role berhasil diupdate',
                'data' => $role
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed " . $e
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $role = role::find($id);
        $role->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'role berhasil dihapus'
        ]);
    }
}
