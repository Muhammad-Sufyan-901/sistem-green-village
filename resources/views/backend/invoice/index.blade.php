@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Invoices</li>
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

    {{-- List Invoices --}}
    <div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h5>List of Invoices</h5>
          </div>
          <div class="col-md-6">
            <div class="d-flex justify-content-end">
              <div>
                <form action="" method="GET">
                  <input type="hidden" name="filter" value="true">
                  <input type="text" class="form-control" name="keyword" placeholder="Search anything..." value="{{ Request::get('keyword') }}" style="width:250px;">
                </form>
              </div>
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
                <th>Payment Request</th>
                <th>Total Payment Rates</th>
                <th>Released By</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($invoices as $key => $item)
                <tr>
                  <td class="text-center">{{ $key + $invoices->firstItem() }}</td>
                  <td>{{ $item->reference_code }}</td>
                  <td>{{ $item->re_payment_request->reference_code }}</td>
                  <td>
                    {{ number_format($item->total_payment_rates, 0, ',', '.') }}
                  </td>
                  <td>{{ isset($item->re_created_by) ? $item->re_created_by->name : '-' }}</td>
                  <td><span class="text-success">Paid</span></td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d/m/Y') }}</td>
                  <td>
                    <a href="{{ Route('backend.invoice.show', $item->invoice_id) }}">
                      <span class="text-primary"><i class='bx bx-info-circle'></i></span>
                    </a>
                    @if(auth()->user()->roles != 'driver')
                      <a href="{{ Route('backend.invoice.edit', $item->invoice_id) }}">
                        <span class="text-primary"><i class='bx bxs-message-square-edit'></i></span>
                      </a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          {{ $invoices->links('backend.partials.pagination') }}
        </div>
      </div>
    </div>
  </div>
@endsection