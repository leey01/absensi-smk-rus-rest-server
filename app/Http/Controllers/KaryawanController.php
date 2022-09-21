<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class KaryawanController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.

     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $karyawan = Karyawan::all();

        return response()->json([
            'message' => 'All data karyawan',
            'data' => $karyawan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function resetPassword(Request $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

    public function me()
    {
        $data = Karyawan::find(Auth::user()->id);
        return response()->json([
            'message' => 'Data Karyawan',
            'data' => $data
        ], Response::HTTP_OK);
    }
}
