<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kalender extends Model
{
    use HasFactory;

    protected $table = 'kalenders';
    
    protected $fillable = ['title', 'description', 'start_time', 'end_time', 'id_karyawan'];

    protected $hidden = [];
}
