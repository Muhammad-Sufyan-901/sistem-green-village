<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TypeTrip;
use App\Models\Trip;

class TripController extends Controller
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
                    $query->orWhere('status', 'LIKE', '%'.strtolower($request->keyword).'%');
                }
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.trip.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get drivers
        $drivers = User::where('roles', 'driver')->get();
        // Get Type Trip
        $tripTypes = TypeTrip::all();

        return view('backend.trip.create', compact('drivers','tripTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store Function
        $store = Trip::create([
            'created_by' => auth()->user()->user_id,
            'driver_id' => $request->select_driver,
            'type_trip_id' => $request->type_trip,
            'name' => $request->name,
            'itinerary' => $request->itinerary,
            'from_date' => $request->from_date,
            'until_date' => $request->until_date,
            'departure_time' => $request->departure_time,
            'status' => $request->status,
        ]);
        if($store)
            return response()->json(['status' => 'success', 'message' => 'Success! data created successfully', 'next' => Route('backend.trip.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = Trip::where('trip_id', $id)->first();
        if(!$trip)
            abort(404);

        // Get drivers
        $drivers = User::where('roles', 'driver')->get();
        // Get Type Trip
        $tripTypes = TypeTrip::all();

        return view('backend.trip.detail', compact('trip','drivers','tripTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trip = Trip::where('trip_id', $id)->first();
        if(!$trip)
            abort(404);

        // Get drivers
        $drivers = User::where('roles', 'driver')->get();
        // Get Type Trip
        $tripTypes = TypeTrip::all();

        return view('backend.trip.edit', compact('trip','drivers','tripTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Arr data update
        $dataUpdate = [
            'created_by' => auth()->user()->user_id,
            'driver_id' => $request->select_driver,
            'type_trip_id' => $request->type_trip,
            'name' => $request->name,
            'itinerary' => $request->itinerary,
            'from_date' => $request->from_date,
            'until_date' => $request->until_date,
            'departure_time' => $request->departure_time,
            'status' => $request->status
        ];

        // Update Function
        $update = Trip::where('trip_id', $id)->update($dataUpdate);
        if($update)
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.trip.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trip = Trip::where('trip_id', $id)->first();
        if(!$trip)
            abort(404);

        // Delete Function
        Trip::where('trip_id', $id)->delete();
        return redirect()->back();
    }
}
