<?php

namespace App\Http\Controllers;

use App\Exports\ExportKehadiran;
use App\Models\Karyawan;
use App\Models\TrxAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Exp;

class KehadiranController extends Controller
{

    // response default kehadiran
    public function kehadiran()
    {
        $startTime = Carbon::now()->format('Y-m-d');

        // Karyawan
        $jmlKaryawan = Karyawan::all()
            ->count();

        $jmlMasuk = TrxAbsensi::listDataOneDay($startTime, 'masuk', 'tercepat')
            ->count();
        $jmlPulang = TrxAbsensi::listDataOneDay($startTime, 'pulang', 'tercepat')
            ->count();
        $jmlAbsen = $jmlKaryawan - $jmlMasuk;

        $listKehadiranMasuk = TrxAbsensi::listDataOneDay($startTime, 'masuk', 'tercepat')
            ->paginate(12);
        $listKehadiranPulang = TrxAbsensi::listDataOneDay($startTime, 'pulang', 'tercepat')
            ->paginate(12);


        $response = response()->json([
           'status' => 'success',
            'message' => 'Response default kehadiran',
            'data' => [
                'jml_kehadiran' => [
                    'jml_masuk' => $jmlMasuk,
                    'jml_pulang' => $jmlPulang,
                    'jml_absen' => $jmlAbsen
                ],
                'list_kehadiran' => [
                    'list_masuk' => $listKehadiranMasuk,
                    'list_pulang' => $listKehadiranPulang
                ]
            ]
        ]);

        return $response;
    }

    // show kehadiran
    public function listAbsensi(Request $request)
    {
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $keterangan = $request->keterangan;
        $urutan = $request->urutan;
        $perPage = $request->per_page;
        $error = [];

        // checking error
        if (!isset($startTime)) {
            array_push($error, 'start_time');
        }

        if (!isset($keterangan)) {
            array_push($error, 'keterangan');
        }

        if (!isset($urutan)) {
            array_push($error, 'urutan');
        }

        if (!isset($perPage)) {
            array_push($error, 'per_page');
        }

        if ($error){
            return response()->json([
                'status' => 'failed',
                'message' => "parameter dibutuhkan!",
                'parameter_dibutuhkan' => $error
            ], 400);
        }

        if (empty($endTime)){
            $list = TrxAbsensi::listDataOneDay($startTime, $keterangan, $urutan)
                ->paginate($perPage);
        } else {
            $list = TrxAbsensi::listDataBetween($startTime, $endTime, $keterangan, $urutan)
                ->paginate($perPage);
        }


        return response()->json([
            'status' => 'success',
            'message' => "List Absensi $keterangan",
            'masa-waktu' => [$startTime, $endTime],
            'urutan' => $urutan,
            'data' => $list,
        ], 200);
    }

    public function jmlKehadiran(Request $request)
    {
        $startTime = $request->start_time;
        $endTime = $request->end_time;
        $keterangan = $request->keterangan;
        $urutan = 'tercepat'; // ga dipake, cuma buat macing function aja
        $error = [];

        $jmlKaryawan = Karyawan::all()
            ->count();


        if (empty($endTime)){
            $jmlMasuk = TrxAbsensi::listDataOneDay($startTime, 'masuk', $urutan)
                ->count();
            $jmlPulang = TrxAbsensi::listDataOneDay($startTime, 'pulang', $urutan)
                ->count();
        } else {
            $jmlMasuk = TrxAbsensi::listDataBetween($startTime, $endTime, 'masuk', $urutan)
                ->count();
            $jmlPulang = TrxAbsensi::listDataBetween($startTime, $endTime, 'pulang', $urutan)
                ->count();
        }

        // jumlah absen
        $jmlAbsen = $jmlKaryawan - $jmlMasuk;

        return response()->json([
            'status' => 'success',
            'message' => 'Jumlah kehadiran Karyawan',
            'jml_karyawan' => $jmlKaryawan,
            'jml_masuk' => $jmlMasuk,
            'jml_pulang' => $jmlPulang,
            'jml_absen' => $jmlAbsen,
            'masa_waktu' => [$startTime, $endTime]
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $startTime = $request->start_time ? : Carbon::now()->format('Y-m-d');
        $endTime = $request->end_time ? : Carbon::now()->format('Y-m-d');

        $trxAbsensi = TrxAbsensi::whereHas('karyawan', function ($q) use($search){
            $q->where('nama', 'like', '%'. $search .'%');
        })->whereBetween('tanggal', [$startTime, $endTime])
            ->with('karyawan')->get();

        if ($trxAbsensi){
            return response()->json([
                'status' => 200,
                'message' => "Data Karyawan berdasarkan $search",
                'data' => $trxAbsensi
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => "Data Karyawan tidak ditemukan!"
            ], 401);
        }

    }

    public function detail(Request $request)
    {
        $id = $request->id;

        $detailKehadiran = TrxAbsensi::find($id);

        return response()->json([
            'status' => 'success',
            'message' => "Detail absensi id $id",
            'data' => $detailKehadiran
        ]);
    }

    public function exportKehadiran(Request $request)
    {
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $keterangan = $request->keterangan;

//        return Excel::download(new ExportKehadiran($start_time, $end_time, $keterangan), "datakehadiran$keterangan($start_time|$end_time).xlsx");
        return (new ExportKehadiran($start_time, $end_time, $keterangan))->download("datakehadiran$keterangan($start_time|$end_time).xlsx");
    }

}
