<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrxAbsensi extends Model
{
    use HasFactory;

    protected $fillable = ['keterangan', 'catatan', 'foto', 'longitude', 'latitude', 'id_karyawan'];
}
