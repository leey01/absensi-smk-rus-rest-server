<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxAbsensi extends Model
{
    use HasFactory;

    protected $fillable = ['keterangan', 'catatan', 'foto', 'longitude', 'latitude', 'id_karyawan'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id');
    }

    public function Roles()
    {
        return $this->belongsTo(role::class);
    }

    // list data today
    public static function listDataOneDay($startTime, $keterangan, $urutan)
    {
        if ($keterangan == 'masuk') {
            if ($urutan == 'tercepat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->where('tanggal', '=', $startTime)
                    ->orderBy('created_at', 'DESC');
            }
            else if ($urutan == 'terlambat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->where('tanggal', '=', $startTime)
                    ->orderBy('created_at', 'ASC');
            }
        }
        else if ($keterangan == 'pulang') {
            if ($urutan == 'tercepat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->where('tanggal', '=', $startTime)
                    ->orderBy('created_at', 'DESC');
            }
            else if ($urutan == 'terlambat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->where('tanggal', '=', $startTime)
                    ->orderBy('created_at', 'ASC');
            }
        }

        return $list;
    }

    // list data custom
    public static function listDataBetween($start_time, $end_time, $keterangan, $urutan)
    {
        if ($keterangan == 'masuk') {
            if ($urutan == 'tercepat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->whereBetween('tanggal', [$start_time, $end_time])
                    ->orderBy('created_at', 'DESC');
            }
            else if ($urutan == 'terlambat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->whereBetween('tanggal', [$start_time, $end_time])
                    ->orderBy('created_at', 'ASC');
            }
        }
        else if ($keterangan == 'pulang') {
            if ($urutan == 'tercepat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->whereBetween('tanggal', [$start_time, $end_time])
                    ->orderBy('created_at', 'DESC');
            }
            else if ($urutan == 'terlambat'){
                $list = TrxAbsensi::with(['karyawan'])
                    ->where('keterangan', "=", $keterangan)
                    ->whereBetween('tanggal', [$start_time, $end_time])
                    ->orderBy('created_at', 'ASC');
            }
        }

        return $list;
    }

    // list masuk staff
    public static function listMasukStaff($startTime)
    {
//        $list = TrxAbsensi::with(['karyawan'])
//            ->where('keterangan', "=", 'masuk')
//            ->where('id_karyawan', '=', 3)
//            ->where('tanggal', '=', $startTime)
//            ->orderBy('created_at', 'DESC');

        $list = TrxAbsensi::whereHas('karyawan', function ($q) {
            $q->where('role_id', 3);
        })->where('keterangan', 'masuk')
            ->get();

        return $list;
    }

    public static function listMasukPengajar($startTime)
    {
        $list = TrxAbsensi::whereHas('karyawan', function ($q) {
            $q->where('role_id', 4);
        })->where('keterangan', 'masuk')
            ->get();

        return $list;
    }
}
