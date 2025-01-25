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
          <a href="{{ Route('backend.my-trip.index') }}">My Trip</a>
        </li>
        <li class="breadcrumb-item active">Edit</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Edit Trip</h5>
    <form action="{{ Route('backend.my-trip.update', $trip->trip_id) }}" method="POST" id="editForm" enctype="multipart/form-data">
      @csrf
      {{ method_field('PATCH') }}
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">Trip Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" base_error="Err_name" value="{{ $trip->name }}" readonly>
              <div id="Err_name" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Type Trip <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="type_trip" base_error="Err_type_trip" value="{{ isset($trip->re_type_trip) ? $trip->re_type_trip->name : '-' }}" readonly>
              <div id="Err_type_trip" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Itinerary <span class="text-danger">*</span></label>
              <textarea name="itinerary" class="form-control" cols="30" rows="6" base_error="Err_itinerary" readonly>{!! $trip->itinerary !!}</textarea>
              <div id="Err_itinerary" class="text-danger"></div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Date Activity <span class="text-danger">*</span></label>
              <div class="row">
                <div class="col-md-6">
                  <input class="form-control" type="date" name="from_date" base_error="Err_from_date" value="{{ $trip->from_date }}" readonly>
                  <div id="Err_from_date" class="text-danger"></div>
                </div>
                <div class="col-md-6">
                  <input class="form-control" type="date" name="until_date" base_error="Err_until_date" value="{{ $trip->until_date }}" readonly>
                  <div id="Err_until_date" class="text-danger"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Departure Time <span class="text-danger">*</span></label>
              <input class="form-control" type="time" name="departure_time" base_error="Err_departure_time" value="{{ $trip->departure_time }}" readonly>
              <div id="Err_departure_time" class="text-danger"></div>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Status <span class="text-danger">*</span></label>
              <br>
              @if ($trip->status == 'done')
                <h4 class="text-success">Done</h4>
              @elseif ($trip->status == 'on-progress')
                <h4 class="text-primary">On Progress</h4>
              @elseif ($trip->status == 'active')
                <h4 class="text-primary">Active</h4>
              @elseif ($trip->status == 'pending')
                <h4 class="text-warning">Pending</h4>
              @else
                <h4 class="text-danger">Cancel</h4>
              @endif
            </div>

            <hr class="mt-4 mb-4">

            <div class="col-md-12 mb-3">
              <label class="form-label">Select Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select" base_error="Err_status">
                <option value="active" {{ $trip->status == 'active' ? 'selected':'' }}>Active</option>
                <option value="on-progress" {{ $trip->status == 'on-progress' ? 'selected':'' }}>On Progress</option>
                <option value="done" {{ $trip->status == 'done' ? 'selected':'' }}>Done</option>
              </select>
              <div id="Err_status" class="text-danger"></div>
            </div>
            <div class="status-done-additional-form" style="{{ $trip->status == 'done' ? 'display: block;':'display: none;' }}">
              <div class="col-md-12 mb-3">
                <label class="form-label">Return Time <span class="text-danger">*</span></label>
                <input class="form-control" type="time" name="return_time" base_error="Err_return_time" value="{{ $trip->return_time }}">
                <div id="Err_return_time" class="text-danger"></div>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" cols="30" rows="6" base_error="Err_remarks">{!! $trip->remarks !!}</textarea>
                <div id="Err_remarks" class="text-danger"></div>
              </div>
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
  <script src="{{ asset('js/backend/functions/my_trip.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      my_trip_init();
      my_trip_update();
    });
  </script>
@endsection