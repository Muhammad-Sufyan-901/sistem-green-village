<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ Route('backend.dash.home') }}" class="app-brand-link">
      <span class="app-brand-logo demo">
        {{-- <img src="{{ asset('img/logo.png') }}" style="width:50px;" alt=""> --}}
      </span>
      <span style="margin-left:10px;">SIM Driver Green Village Backend</span>      
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Main Menu</span>
    </li>
    {{-- Dashboard --}}
    <li class="menu-item {{ \Request::route()->getName() == 'backend.dash.home' ? 'active':'' }}">
      <a href="{{ Route('backend.dash.home') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>
    {{-- Users --}}
    @if (auth()->user()->roles == 'admin')
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.users.index' || 
          \Request::route()->getName() == 'backend.users.create' || 
          \Request::route()->getName() == 'backend.users.edit' || 
          \Request::route()->getName() == 'backend.users.show' 
          ? 'active':'' 
        }}">
          <a href="{{ Route('backend.users.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div>Users</div>
          </a>
      </li>
    @endif
    {{-- Drivers --}}
    @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'receptionist' || auth()->user()->roles == 'accounting')
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.drivers.index' || 
          \Request::route()->getName() == 'backend.drivers.create' || 
          \Request::route()->getName() == 'backend.drivers.edit' || 
          \Request::route()->getName() == 'backend.drivers.show' 
          ? 'active':'' 
        }}">
          <a href="{{ Route('backend.drivers.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user-voice"></i>
            <div>Drivers</div>
          </a>
      </li>
    @endif
    {{-- Trip --}}
    @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'receptionist' || auth()->user()->roles == 'accounting')
      {{-- <li class="menu-item {{ 
           
        }}">
          <a href="{{ Route('backend.trip.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-map-alt"></i>
            <div>Trip</div>
          </a>
      </li> --}}

      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.type-trip.index' || 
          \Request::route()->getName() == 'backend.type-trip.create' || 
          \Request::route()->getName() == 'backend.type-trip.edit' || 
          \Request::route()->getName() == 'backend.type-trip.show' ||
          \Request::route()->getName() == 'backend.trip.index' || 
          \Request::route()->getName() == 'backend.trip.create' || 
          \Request::route()->getName() == 'backend.trip.edit' || 
          \Request::route()->getName() == 'backend.trip.show' 
          ? 'active open':'' 
        }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-map-alt"></i>
          <div>Trip</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ 
            \Request::route()->getName() == 'backend.type-trip.index' || 
            \Request::route()->getName() == 'backend.type-trip.create' || 
            \Request::route()->getName() == 'backend.type-trip.edit' || 
            \Request::route()->getName() == 'backend.type-trip.show' ? 'active':'' 
          }}">
            <a href="{{ Route('backend.type-trip.index') }}" class="menu-link">
              <div>Type Trip</div>
            </a>
          </li>
          <li class="menu-item {{ 
            \Request::route()->getName() == 'backend.trip.index' || 
            \Request::route()->getName() == 'backend.trip.create' || 
            \Request::route()->getName() == 'backend.trip.edit' || 
            \Request::route()->getName() == 'backend.trip.show' ? 'active':'' 
          }}">
            <a href="{{ Route('backend.trip.index') }}" class="menu-link">
              <div>List Trip</div>
            </a>
          </li>
        </ul>
      </li>
    @endif
    <li class="menu-item {{ 
      \Request::route()->getName() == 'backend.trip.index' || 
      \Request::route()->getName() == 'backend.trip.create' || 
      \Request::route()->getName() == 'backend.trip.edit' || 
      \Request::route()->getName() == 'backend.trip.show' ? 'active':'' 
    }}">
      <a href="{{ Route('backend.trip.index') }}" class="menu-link" data-bs-toggle="modal" data-bs-target="#modalTransportPriceList">
        <i class="menu-icon tf-icons bx bx-info-circle"></i>
        <div>Transport Price List</div>
      </a>
    </li>

    {{-- Driver Roles --}}
    @if (auth()->user()->roles == 'driver')
      {{-- Trip --}}
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.my-trip.index' || 
          \Request::route()->getName() == 'backend.my-trip.create' || 
          \Request::route()->getName() == 'backend.my-trip.edit' 
          ? 'active':'' 
        }}">
          <a href="{{ Route('backend.my-trip.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-map-alt"></i>
            <div>
              My Trip 
              @php
                $totalActiveTask = \App\Models\Trip::where('driver_id', auth()->user()->user_id)
                ->where('status', 'active')
                ->count();
              @endphp
              @if ($totalActiveTask > 0)
                <div class="badge bg-danger rounded-pill ms-auto pl-2">{{ $totalActiveTask }}</div>
              @endif
            </div>
          </a>
      </li>
    @endif

    @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting' || auth()->user()->roles == 'driver')
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Payment</span>
      </li>
      {{-- Payment Request --}}
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.payment-request.index' || 
          \Request::route()->getName() == 'backend.payment-request.create' || 
          \Request::route()->getName() == 'backend.payment-request.edit' || 
          \Request::route()->getName() == 'backend.payment-request.show' 
          ? 'active':'' 
        }}">
          <a href="{{ Route('backend.payment-request.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-log-in-circle"></i>
            <div>
              Payment Requests
              @if (auth()->user()->roles == 'admin')
                @php
                  $totalPendingPaymentRequest = \App\Models\PaymentRequest::where('status', 'pending')
                  ->count();
                @endphp
                @if ($totalPendingPaymentRequest > 0)
                  <div class="badge bg-danger rounded-pill ms-auto pl-2">{{ $totalPendingPaymentRequest }}</div>
                @endif
              @endif
            </div>
          </a>
      </li>
      {{-- Invoice --}}
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.invoice.index' || 
          \Request::route()->getName() == 'backend.invoice.create' || 
          \Request::route()->getName() == 'backend.invoice.edit' || 
          \Request::route()->getName() == 'backend.invoice.show' 
          ? 'active':'' 
        }}">
          <a href="{{ Route('backend.invoice.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-receipt"></i>
            <div>
              Invoices
            </div>
          </a>
      </li>
    @endif

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Others</span>
    </li>
    {{-- Report --}}
    @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting' || auth()->user()->roles == 'receptionist')
      <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.dash.report.trip.index' || 
          \Request::route()->getName() == 'backend.dash.report.payment-request.index' || 
          \Request::route()->getName() == 'backend.dash.report.invoice.index' ? 'active open':'' 
        }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-book-alt"></i>
          <div>Reports</div>
        </a>
        <ul class="menu-sub">
          @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting' || auth()->user()->roles == 'receptionist')
            <li class="menu-item {{ 
                \Request::route()->getName() == 'backend.dash.report.trip.index' ? 'active':'' 
              }}">
              <a href="{{ Route('backend.dash.report.trip.index') }}" class="menu-link">
                <div>Trip</div>
              </a>
            </li>
          @endif
          @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting')
            <li class="menu-item {{ 
                \Request::route()->getName() == 'backend.dash.report.payment-request.index' ? 'active':'' 
              }}">
              <a href="{{ Route('backend.dash.report.payment-request.index') }}" class="menu-link">
                <div>Payment Request</div>
              </a>
            </li>
          @endif
          @if (auth()->user()->roles == 'admin' || auth()->user()->roles == 'accounting')
            <li class="menu-item {{ 
                \Request::route()->getName() == 'backend.dash.report.invoice.index' ? 'active':'' 
              }}">
              <a href="{{ Route('backend.dash.report.invoice.index') }}" class="menu-link">
                <div>Invoice</div>
              </a>
            </li>
          @endif
        </ul>
      </li>
    @endif
    {{-- Settings --}}
    <li class="menu-item {{ 
        \Request::route()->getName() == 'backend.dash.edit-profile.index' || 
        \Request::route()->getName() == 'backend.dash.change-password.index' ? 'active open':'' 
      }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div>Settings</div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.dash.edit-profile.index' ? 'active':'' 
        }}">
          <a href="{{ Route('backend.dash.edit-profile.index') }}" class="menu-link">
            <div>Edit Profile</div>
          </a>
        </li>
        <li class="menu-item {{ 
          \Request::route()->getName() == 'backend.dash.change-password.index' ? 'active':'' 
        }}">
          <a href="{{ Route('backend.dash.change-password.index') }}" class="menu-link">
            <div>Change Password</div>
          </a>
        </li>
      </ul>
    </li>
    {{-- Logout --}}
    <li class="menu-item">
      <a href="{{ Route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-sidemenu').submit();" class="menu-link">
        <i class="menu-icon tf-icons bx bx-power-off"></i>
        <span class="align-middle">Log Out</span>
      </a>
      <form id="logout-form-sidemenu" class="btn btn-default" action="{{ Route('auth.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>   
    </li>
  </ul>
</aside>

{{-- Transport Price List Modal --}}
<div class="modal fade" id="modalTransportPriceList" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Transport Price List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          @if (auth()->user()->roles == 'admin')
            <div class="col-md-12">
              <form action="{{ Route('backend.dash.upload-transport-price-list') }}" method="POST" id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="upload-alert-message-box"></div>
                <div class="mb-3">
                  <label>Upload Photo <span class="text-danger">*</span></label>
                  <input type="file" name="photo" class="form-control" base_error="Err_upload_photo_transport_price_list" accept="image/jpg">
                  <div id="Err_upload_photo_transport_price_list" class="text-danger"></div>
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn btn-success btn-submit">Submit</button>
                </div>
              </form>
            </div>
            <hr class="mt-3 mb-3">
          @endif
          <div class="col-md-12">
            <a href="{{ asset('img/transport-price-list.jpg') }}">
              <img src="{{ asset('img/transport-price-list.jpg') }}" class="w-100 tpl-img-preview" alt="">
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>