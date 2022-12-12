<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\TrxAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\KehadiranController;

class DashboardController extends Controller
{

    public function dashboard(Request $request){

        /* Jumlah Kehadiran */
        $startTime = $request->start_time ? : Carbon::now()->format('Y-m-d');
        $endTime = $request->end_time ? : Carbon::now()->format('Y-m-d');
        $urutan = 'tercepat';

        // Karyawan
        $jmlKaryawan = Karyawan::all()
            ->count();

        // Jumlah Kehadiran today
        $jmlMasuk = TrxAbsensi::listDataOneDay($startTime, 'masuk', $urutan)
            ->count();
        $jmlPulang = TrxAbsensi::listDataOneDay($startTime, 'pulang', $urutan)
            ->count();
        $jmlAbsen = $jmlKaryawan - $jmlMasuk;


        $response = response()->json([
           'status' => 'success',
           'message' => 'Response default Dashboard',
           'data' => [
               'jml_kehadiran' => [
                   'jml_karyawan' => $jmlKaryawan,
                   'jml_masuk' => $jmlMasuk,
                   'jml_pulang' => $jmlPulang,
                   'jml_absen' => $jmlAbsen
               ]
           ]
        ]);

        return $response;

    }

    public function jmlKehadiran(Request $request)
    {
        $startTime = $request->start_time;
        $endTime = $request->end_time;
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

    public function DonloadKehadiran()
    {
        //
    }
}
