@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.trip.index') }}">Trip</a>
        </li>
        <li class="breadcrumb-item active">Create</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Create Trip</h5>
    <form action="{{ Route('backend.trip.store') }}" method="POST" id="addForm" enctype="multipart/form-data">
      @csrf
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Trip Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" base_error="Err_name">
              <div id="Err_name" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Driver Available <span class="text-danger">*</span></label>
              <select name="select_driver" class="form-select" base_error="Err_select_driver">
                <option value="">-- Please Select --</option>
                @foreach ($drivers as $key => $item)
                  @php
                    $totalHandle = \App\Models\Trip::where('driver_id', $item->user_id)->where('status', 'active')->count();
                  @endphp
                  @if ($totalHandle == 0)
                    <option value="{{ $item->user_id }}">{{ $item->name }}</option>
                  @endif
                @endforeach
              </select>
              <div id="Err_select_driver" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Type Trip <span class="text-danger">*</span></label>
              <select name="type_trip" class="form-select" base_error="Err_type_trip">
                <option value="">-- Please Select --</option>
                @foreach ($tripTypes as $key => $item)
                  <option value="{{ $item->type_trip_id }}">{{ $item->name }}</option>
                @endforeach
              </select>
              <div id="Err_type_trip" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Itinerary <span class="text-danger">*</span></label>
              <textarea name="itinerary" class="form-control" cols="30" rows="6" base_error="Err_itinerary"></textarea>
              <div id="Err_itinerary" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date Activity <span class="text-danger">*</span></label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" type="date" name="from_date" base_error="Err_from_date">
                  <div id="Err_from_date" class="text-danger"></div>
                </div>
                <div class="col-md-6">
                  <input class="form-control" type="date" name="until_date" base_error="Err_until_date">
                  <div id="Err_until_date" class="text-danger"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Departure Time <span class="text-danger">*</span></label>
              <input class="form-control" type="time" name="departure_time" base_error="Err_departure_time">
              <div id="Err_departure_time" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Select Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select" base_error="Err_status">
                <option value="active">Active</option>
                <option value="done">Done</option>
                <option value="pending">Pending</option>
                <option value="cancel">Cancel</option>
              </select>
              <div id="Err_status" class="text-danger"></div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn rounded-pill btn-primary btn-submit">Submit</button>
        </div>
      </div>
    </form>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/backend/functions/trip.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      trip_store();
    });
  </script>
@endsection