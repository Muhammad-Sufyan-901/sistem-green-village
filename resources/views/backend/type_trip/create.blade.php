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
        <li class="breadcrumb-item active">Create</li>
      </ol>
    </nav>

    {{-- Form --}}
    <div class="alert-message-box"></div>
    <h5 class="mt-4 mb-4">Create Type Trip</h5>
    <form action="{{ Route('backend.type-trip.store') }}" method="POST" id="addForm" enctype="multipart/form-data">
      @csrf
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label class="form-label">Type Name <span class="text-danger">*</span></label>
              <input class="form-control" type="text" name="name" base_error="Err_name">
              <div id="Err_name" class="text-danger"></div>
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
  <script src="{{ asset('js/backend/functions/type_trip.js') }}"></script>
  <script defer="defer">
    window.addEventListener('DOMContentLoaded', function() {
      type_trip_store();
    });
  </script>
@endsection