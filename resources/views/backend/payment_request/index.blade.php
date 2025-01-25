@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Payment Requests</li>
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

    {{-- List Payment Requests --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>List of Payment Requests</h5>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div>
                <form action="" method="GET">
                  <input type="hidden" name="filter" value="true">
                  <input type="text" class="form-control" name="keyword" placeholder="Search anything..." value="{{ Request::get('keyword') }}" style="width:250px;">
                </form>
              </div>
              @if (auth()->user()->roles == 'driver')
                <a href="{{ Route('backend.payment-request.create') }}" class="btn btn-success" style="margin-left: 10px;">
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
                <th>Reference Code</th>
                <th>Trip</th>
                <th>Total Rates Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($paymentRequests as $key => $item)
                <tr>
                  <td class="text-center">{{ $key + $paymentRequests->firstItem() }}</td>
                  <td>{{ $item->reference_code }}</td>
                  <td>{{ $item->re_trip->name }}</td>
                  <td>
                    {{ number_format($item->total_rates_amount, 0, ',', '.') }}
                  </td>
                  <td>
                    @if ($item->status == 'done')
                      <span class="text-success">Done</span>
                    @elseif ($item->status == 'pending')
                      <span class="text-warning">Pending</span>
                    @else
                      <span class="text-danger">Cancel</span>
                    @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</td>
                  <td>
                    <a href="{{ Route('backend.payment-request.show', $item->payment_request_id) }}">
                      <span class="text-primary"><i class='bx bx-info-circle'></i></span>
                    </a>
                    @if (auth()->user()->user_id == $item->user_id && $item->status != 'done')
                      <a href="{{ Route('backend.payment-request.edit', $item->payment_request_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                    @elseif((auth()->user()->roles == 'admin') || (auth()->user()->roles == 'accounting'))
                      <a href="{{ Route('backend.payment-request.edit', $item->payment_request_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $paymentRequests->links('backend.partials.pagination') }}
        </div>
      </div>
    </div>
  </div>
@endsection