<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\role;
use App\Models\TrxAbsensi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KaryawanController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    /**
     * Display a listing of the resource.

     * @return \Illuminate\Http\JsonResponse
     */

//    public function index()
//    {
//        $per_page = 4;
//        $list = DB::table('karyawans')->paginate($per_page);
//
//        return response()->json([
//            'status' => 'success',
//            'message' => 'Data Karyawan',
//            'data' => $list
//        ]);
//    }

    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'message' => 'Profil User',
            'data' => $user
        ]);
    }

    public function karyawan(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = $request->per_page;

        if ($perPage){
            $karyawan = DB::table('karyawans')->paginate($perPage);
        } else {
            $karyawan = DB::table('karyawans')->get();
        }


        return response()->json([
            'message' => 'All data karyawan',
            'data' => $karyawan
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
            'nama' => ['required'],
            'email' => ['required', 'email'],
            'niy' => ['required', 'unique'],
            'password' => ['required'],
            'alamat' => ['required'],
            'no_hp' => ['required'],
            'role_id' => ['required'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $absensi = Karyawan::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'niy' => $request->niy,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ]);

            $response = [
                'status' => 'success',
                'message' => 'Data Karyawan berhasil dibuat',
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $karyawan = Karyawan::find($id);

        return response()->json([
           'message' => "Detail Karyawan by id $id",
           'data' => $karyawan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        $validator = Validator::make(request()->all(), [
            'nama' => ['required'],
            'email' => ['required|email'],
            'niy' => ['required', 'unique'],
            'password' => ['password'],
            'alamat' => ['required'],
            'no_hp' => ['required'],
            'role_id' => ['required'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        try {
            $karyawan->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'niy' => $request->niy,
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'role_id' => $request->role_id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
                'data' => $karyawan
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->id;

        $karyawan = Karyawan::find($id);
        $karyawan->delete();

        return response()->json([
           'status' => 'success',
           'message' => 'Karyawan berhasil dihapus'
        ]);
    }
}
