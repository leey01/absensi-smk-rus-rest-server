<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'nama' => 'required|string',
            'niy' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'alamat' => 'required|string',
            'no_hp' => 'required|string',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $karyawan = Karyawan::create([
            'nama' => request('nama'),
            'niy' => request('niy'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'alamat' => request('alamat'),
            'no_hp' => request('no_hp'),
            'role_id' => request('role_id'),
        ]);

        $token = $karyawan->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $karyawan,'access_token' => $token, 'token_type' => 'Bearer', ]);
    }

    public function login(Request $request)
    {
        $karyawan = Karyawan::where('niy', $request->niy)->first();

        if ($karyawan->niy == $request->niy && Hash::check($request->password, $karyawan->password)){
            $token = $karyawan->createToken('token-name')->plainTextToken;

            return response()->json([
                'messege' => 'success',
                'user' => $karyawan,
                'token' => $token
            ], 200);

        }

        return response()->json([
            'messege' => 'UNAUTHORIZED'
        ], 401);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }
}
