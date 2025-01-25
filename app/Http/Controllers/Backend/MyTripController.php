<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Trip;

class MyTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $trips = Trip::with(['re_type_trip'])->where(function($query) use ($request) {
            // Filter
            if($request->filter == 'true')
            {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('status', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('confirmation', 'LIKE', '%'.$request->keyword.'%');
            }

            $query->where('driver_id', auth()->user()->user_id);
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.my_trip.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trip = Trip::with(['re_type_trip'])->where('trip_id', $id)
        ->where('driver_id', auth()->user()->user_id)
        ->first();
        if(!$trip)
            abort(404);

        return view('backend.my_trip.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Arr data update
        $dataUpdate = [
            'status' => $request->status,
            'return_time' => $request->status == 'done' ? $request->return_time : null,
            'remarks' => $request->status == 'done' ? $request->remarks : null
        ];

        // Update Function
        $update = Trip::where('trip_id', $id)->update($dataUpdate);
        if($update)
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.my-trip.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
