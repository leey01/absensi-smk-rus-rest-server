<?php

namespace App\Exports;

use App\Models\TrxAbsensi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportKehadiran implements FromQuery, WithHeadings
{

    use Exportable;

    protected $start_time;
    protected $end_time;
    protected $keterangan;
    

    public function __construct($start_time, $end_time, $keterangan)
    {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->keterangan = $keterangan;
    }

    public function headings(): array
    {
        return [
            'id',
            'id_karyawan',
            'keterangan',
            'catatan',
            'waktu',
            'tanggal',
            'foto',
            'longitude',
            'latitude',
            'created_at',
            'updated_at',
        ];
    }

    public function query()
    {
        return TrxAbsensi::query()
            ->where('keterangan', $this->keterangan)
            ->whereBetween('tanggal', [$this->start_time, $this->end_time]);
    }
}
