<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Trip;
use App\Models\PaymentRequest;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDrivers = User::where('roles', 'driver')->count();
        $totalTrip = Trip::count();
        $totalPendingPaymentRequest = PaymentRequest::where('status', 'pending')->count();
        $totalInvoice = Invoice::count();

        return view('backend.index', compact('totalDrivers', 'totalTrip', 'totalPendingPaymentRequest', 'totalInvoice'));
    }
}
