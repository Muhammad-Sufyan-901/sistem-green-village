<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\TypeTrip;

class TypeTripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $typeTrips = TypeTrip::where(function($query) use ($request) {
            // Filter
                if($request->filter == 'true')
                {
                    $query->where('name', 'LIKE', '%'.$request->keyword.'%');
                }
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.type_trip.index', compact('typeTrips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.type_trip.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store Function
        $store = TypeTrip::create([ 
            'name' => $request->name
        ]);
        if($store)
            return response()->json(['status' => 'success', 'message' => 'Success! data created successfully', 'next' => Route('backend.type-trip.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $typeTrip = TypeTrip::where('type_trip_id', $id)->first();
        if(!$typeTrip)
            abort(404);

        return view('backend.type_trip.detail', compact('typeTrip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $typeTrip = TypeTrip::where('type_trip_id', $id)->first();
        if(!$typeTrip)
            abort(404);

        return view('backend.type_trip.edit', compact('typeTrip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Arr data update
        $dataUpdate = [
            'name' => $request->name
        ];

        // Update Function
        $update = TypeTrip::where('type_trip_id', $id)->update($dataUpdate);
        if($update)
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.type-trip.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type_trip = TypeTrip::where('type_trip_id', $id)->first();
        if(!$type_trip)
            abort(404);

        // Delete Function
        TypeTrip::where('type_trip_id', $id)->delete();
        return redirect()->back();
    }
}
