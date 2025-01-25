@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ Route('backend.dash.home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">Report Payment Request</li>
      </ol>
    </nav>

    @php
        $qBuilder = [
          'filter' => Request::get('filter'),
          'from_date' => Request::get('from_date'),
          'until_date' => Request::get('until_date'),
          'status' => Request::get('status')
        ];
        $buildQ = http_build_query($qBuilder, '', '&');
    @endphp

    <div class="card">
      <div class="card-body">
        <div class="text-nowrap">
          <form id="formAccountSettings" method="GET" action="{{ route('backend.dash.report.payment-request.index') }}">
            <input type="hidden" name="filter" value="true">
            <div class="row">
              <div class="mb-3 col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <label class="form-label">Date</label>
                  </div>
                  <div class="col-md-6">
                    <input type="date" class="form-control" name="from_date" value="{{ Request::get('from_date') }}">
                  </div>
                  <div class="col-md-6">
                    <input type="date" class="form-control" name="until_date" value="{{ Request::get('until_date') }}">
                  </div>
                </div>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                  <option value="">-- Select All --</option>
                  <option value="cancel" {{ Request::get('status') == 'cancel' ? 'selected':'' }}>Cancel</option>
                  <option value="pending" {{ Request::get('status') == 'pending' ? 'selected':'' }}>Pending</option>
                  <option value="done" {{ Request::get('status') == 'done' ? 'selected':'' }}>Done</option>
                </select>
              </div>
            </div>
            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    @if (Request::get('filter'))
      <div class="card mt-4">
        <div class="card-body">                
          <div class="demo-inline-spacing">
            <a href="{{ route('backend.dash.report.payment-request.download-pdf', $buildQ) }}" class="btn btn-outline-primary">Download Rekap PDF</a>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection