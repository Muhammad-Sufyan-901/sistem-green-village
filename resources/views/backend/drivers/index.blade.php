@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Drivers</li>
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

    {{-- List Drivers --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>List of Drivers</h5>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div>
                <form action="" method="GET">
                  <input type="hidden" name="filter" value="true">
                  <input type="text" class="form-control" name="keyword" placeholder="Search anything..." value="{{ Request::get('keyword') }}" style="width:250px;">
                </form>
              </div>
              @if (auth()->user()->roles == 'admin')
                <a href="{{ Route('backend.drivers.create') }}" class="btn btn-success" style="margin-left: 10px;">
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
                <th>Roles</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $key => $item)
                <tr>
                  <td class="text-center">{{ $key + $users->firstItem() }}</td>
                  <td>{{ ucwords($item->roles) }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->phone }}</td>
                  <td>
                    @if ($item->status == 'active')
                      <span class="text-success">Active</span>
                    @else
                      <span class="text-danger">Not Active</span>
                    @endif
                  </td>
                  <td>
                    <a href="{{ Route('backend.drivers.show', $item->user_id) }}">
                      <span class="text-primary"><i class='bx bx-info-circle'></i></span>
                    </a>
                    @if (auth()->user()->roles == 'admin')
                      <a href="{{ Route('backend.drivers.edit', $item->user_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                      <form action="{{ Route('backend.drivers.destroy', $item->user_id) }}" id="form-delete-{{ $item->user_id }}" class="d-inline-block cursor-pointer" method="POST">
                        @method('DELETE')
                        @csrf
                        <span class="text-danger" onclick="submitForm('form-delete-{{ $item->user_id }}')"><i class='bx bxs-trash'></i></span></a>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $users->links('backend.partials.pagination') }}
        </div>
      </div>
    </div>
  </div>
@endsection