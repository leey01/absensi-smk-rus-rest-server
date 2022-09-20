<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['id', 'nama', 'password', 'niy', 'email', 'alamat', 'no_hp', 'role_id', 'id_karyawan'];

//    protected $hidden = [
//        'password'
//    ];

    public function User(){
     return $this->belongsTo(User::class);
    }

}
