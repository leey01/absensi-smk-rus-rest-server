<?php

namespace App\Http\Controllers;

use App\Models\TrxAbsensi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'keterangan' => ['required'],
            'foto' => ['required'],
            'longitude' => ['required'],
            'latitude' => ['required'],
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $absensi = TrxAbsensi::create([
                'keterangan' => $request->keterangan,
                'catatan' => $request->catatan,
                'foto' => $request->foto,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'id_karyawan' => Auth::user()->id,
            ]);

            $response = [
                'message' => 'Absen Berhasil',
                'data' => $absensi
            ];

            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
                return response()->json([
                    'message' => "Failed " . $e
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


//    Filtering
//    Filter Masuk Pulang
    public function listAbsensi(Request $request)
    {
        $list = TrxAbsensi::with(['karyawan'])->where('keterangan', "=", $request->keterangan)->orderBy('created_at', 'DESC')->get();

        return response()->json([
            'message' => 'List Absensi Masuk',
            'data' => $list
        ], 200);
    }
}

//     Filter daily
