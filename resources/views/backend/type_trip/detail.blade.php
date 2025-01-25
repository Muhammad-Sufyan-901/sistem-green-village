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
          <a href="{{ Route('backend.type-trip.index') }}">Type Trip</a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
      </ol>
    </nav>

    <h5 class="mt-4 mb-4">Detail Type Trip</h5>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label">Trip Name</label>
            <input class="form-control" type="text" name="name" base_error="Err_name" value="{{ $typeTrip->name }}" readonly>
            <div id="Err_name" class="text-danger"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection