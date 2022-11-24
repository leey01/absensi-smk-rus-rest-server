<?php

namespace App\Http\Controllers;

use App\Models\Kalender;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index()
    {
        $events = array();
        $bookings = Kalender::all();
        foreach ($bookings as $booking) {
            $events[] = [
                'id'=>$booking->id,
                'id_karyawan'=>$booking->id_karyawan,
                'title'=>$booking->title,
                'description'=>$booking->description,
                'start'=>$booking->start_time,
                'end'=>$booking->end_time
            ];
        }

        return response()->json(['events'=>$events]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|string|max:255',
          ]);
          $booking = Kalender::create([
                  'id_karyawan'=>$request->id_karyawan,
                  'title'=>$request->title,
                  'description'=>$request->description,
                  'start_time'=>$request->start_time,
                  'end_time'=>$request->end_time,
          ]);
   
          return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Kalender::find($id);
        if (! $booking) {
          return response()->json([
            'error'=>'Unable to locate the event'
          ], 404);
        }
        $booking->update([
          'start_time'=>$request->start_time,
          'end_time'=>$request->end_time,
        ]);

        return response()->json([
            'message'=>'Event updated'
        ]);
    }

    public function edit(Request $request, $id)
    {
       $events = array();
       $request->validate([
        'title'=>'required|string|max:255',
      ]);
       $booking = Kalender::find($id)->update($events = [
            'title'=>$request->title,            
            'description'=>$request->description,
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'Data berhasil diubah',
            'data'=>$events
        ]);
    }

    public function destroy(Request $request, $id)
    {
      $booking = Kalender::find($id);
      if (! $booking) {
        return response()->json([
          'error'=>'Unable to locate the event'
        ], 404);
      }
      $booking->delete();
      return response()->json(['message'=>'Delete Success']);
    }
}
