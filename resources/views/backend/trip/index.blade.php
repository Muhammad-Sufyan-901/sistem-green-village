@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Trip</li>
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

    {{-- List Trip --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>List of Trip</h5>
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
                <a href="{{ Route('backend.trip.create') }}" class="btn btn-success" style="margin-left: 10px;">
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
                <th>Trip Name</th>
                <th>Type</th>
                <th>Date Activity</th>
                <th>Departure Time</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($trips as $key => $item)
                <tr>
                  <td class="text-center">{{ $key + $trips->firstItem() }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ isset($item->re_type_trip) ? $item->re_type_trip->name : '-' }}</td>
                  <td>
                    {{ \Carbon\Carbon::parse($item->from_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->until_date)->format('d/m/Y') }}
                  </td>
                  <td>{{ \Carbon\Carbon::parse($item->departure_time)->format('g:i A') }}</td>
                  <td>{{ isset($item->re_driver) ? $item->re_driver->name : '' }}</td>
                  <td>
                    @if ($item->status == 'done')
                      <span class="text-success">Done</span>
                    @elseif ($item->status == 'on-progress')
                      <span class="text-primary">On Progress</span>
                    @elseif ($item->status == 'active')
                      <span class="text-primary">Active</span>
                    @elseif ($item->status == 'pending')
                      <span class="text-warning">Pending</span>
                    @else
                      <span class="text-danger">Cancel</span>
                    @endif
                  </td>
                  <td>{{ isset($item->re_created_by) ? $item->re_created_by->name : '' }}</td>
                  <td>
                    <a href="{{ Route('backend.trip.show', $item->trip_id) }}">
                      <span class="text-primary"><i class='bx bx-info-circle'></i></span>
                    </a>
                    @if ((auth()->user()->roles == 'admin') || ($item->created_by == auth()->user()->user_id))
                      <a href="{{ Route('backend.trip.edit', $item->trip_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                    @endif
                    @if ((auth()->user()->roles == 'admin'))
                      <form action="{{ Route('backend.trip.destroy', $item->trip_id) }}" id="form-delete-{{ $item->trip_id }}" class="d-inline-block cursor-pointer" method="POST">
                        @method('DELETE')
                        @csrf
                        <span class="text-danger" onclick="submitForm('form-delete-{{ $item->trip_id }}')"><i class='bx bxs-trash'></i></span></a>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $trips->links('backend.partials.pagination') }}
        </div>
      </div>
    </div>
  </div>
@endsection