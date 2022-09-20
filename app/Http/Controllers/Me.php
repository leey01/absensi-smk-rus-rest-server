<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class Me extends Controller
{
    public function index()
    {
        $data = Karyawan::find(Auth::user()->id);
        return response()->json([
            'message' => 'Data Karyawan',
            'data' => $data
        ], Response::HTTP_OK);
    }
}
