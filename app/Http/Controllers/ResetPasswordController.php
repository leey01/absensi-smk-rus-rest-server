<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function sendResetResponse(Request $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $input = $request->only('old_password', 'new_password');
        $validator = Validator::make($input, [
            'old_password' => 'required',
            'new_password' => 'required|different:password',
        ]);

        $karyawan = Karyawan::find(Auth::user()->id);

        if ($validator->fails()) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }

        if (Hash::check($request->old_password, $karyawan->password)) {
            $karyawan->update([
                'password' => Hash::make(request('new_password'))
            ]);

            $message = 'Password reset successfully';
        } else {
            $message = 'Failed to reset password';
        }

        $response = ['message' => $message, 'status' => 'Updated'];
        return response()->json($response, 200);


    }
}
