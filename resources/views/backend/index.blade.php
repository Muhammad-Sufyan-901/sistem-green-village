@extends('backend.app')

@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="javascript:void(0);">Home</a>
        </li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>

    <div class="row">
      {{-- Welcome --}}
      <div class="col-lg-12 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Hii {{ auth()->user()->name }}, Welcome to your dashboard! 🎉</h5>
                <p class="mb-4">Start taking full control to manage your Content Management System.</p>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{ asset('img/man-with-laptop-light.png') }}" height="140">
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Total Drivers --}}
      @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'receptionist' || auth()->user()->roles == 'accounting')
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <p class="mb-1">Total Driver</p>
              <h4 class="card-title mb-3">{{ $totalDrivers }}</h4>
            </div>
          </div>
        </div>
      @endif

      {{-- Total Trip --}}
      @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'receptionist' || auth()->user()->roles == 'accounting')
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <p class="mb-1">Total Trip</p>
              <h4 class="card-title mb-3">{{ $totalTrip }}</h4>
            </div>
          </div>
        </div>
      @endif

      {{-- Total Pending Payment Request --}}
      @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting')
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <p class="mb-1">Total Pending Payment Request</p>
              <h4 class="card-title mb-3">{{ $totalPendingPaymentRequest }}</h4>
            </div>
          </div>
        </div>
      @endif

      {{-- Total Invoice --}}
      @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting')
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <div class="card-body">
              <p class="mb-1">Total Invoice</p>
              <h4 class="card-title mb-3">{{ $totalInvoice }}</h4>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection