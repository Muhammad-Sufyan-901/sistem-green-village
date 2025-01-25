@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Type Trip</li>
      </ol>
    </nav>

    {{-- Condition if filter action --}}
    @if (Request::get('filter') == true)
      <p>
        <strong>Filter By:</strong><br>
        <ul>
          @if (Request::get('keyword'))
            <li><b>Keyword: </b> {{ Request::get('keyword') }}</li>
          @endif
        </ul>
      </p>
    @endif

    {{-- List Type Trip --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>List of Type Trip</h5>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div>
                <form action="" method="GET">
                  <input type="hidden" name="filter" value="true">
                  <input type="text" class="form-control" name="keyword" placeholder="Search anything..." value="{{ Request::get('keyword') }}" style="width:250px;">
                </form>
              </div>
              @if ((auth()->user()->roles == 'admin') || (auth()->user()->roles == 'receptionist'))
                <a href="{{ Route('backend.type-trip.create') }}" class="btn btn-success" style="margin-left: 10px;">
                  <i class='bx bx-plus'></i>
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive text-nowrap">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center"><b>No</b></th>
                <th>Type Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($typeTrips as $key => $item)
                <tr>
                  <td class="text-center">{{ $key + $typeTrips->firstItem() }}</td>
                  <td>{{ $item->name }}</td>
                  <td>
                    <a href="{{ Route('backend.type-trip.show', $item->type_trip_id) }}">
                      <span class="text-primary"><i class='bx bx-info-circle'></i></span>
                    </a>
                    @if ((auth()->user()->roles == 'admin') || ($item->created_by == auth()->user()->user_id))
                      <a href="{{ Route('backend.type-trip.edit', $item->type_trip_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                    @endif
                    @if ((auth()->user()->roles == 'admin'))
                      <form action="{{ Route('backend.type-trip.destroy', $item->type_trip_id) }}" id="form-delete-{{ $item->type_trip_id }}" class="d-inline-block cursor-pointer" method="POST">
                        @method('DELETE')
                        @csrf
                        <span class="text-danger" onclick="submitForm('form-delete-{{ $item->type_trip_id }}')"><i class='bx bxs-trash'></i></span></a>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $typeTrips->links('backend.partials.pagination') }}
        </div>
      </div>
    </div>
  </div>
@endsection