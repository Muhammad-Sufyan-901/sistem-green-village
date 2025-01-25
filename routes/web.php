<?php

use Illuminate\Support\Facades\Route;

// Other
    use App\Http\Controllers\Backend\UploadTransportPriceList;
// Auth
    use App\Http\Controllers\Auth\LoginController;
    use App\Http\Controllers\Auth\RegisterController;
    use App\Http\Controllers\Auth\LogoutController;
    use App\Http\Controllers\Auth\ForgotPasswordController;
    use App\Http\Controllers\Auth\ResetPasswordController;
// Backend
    use App\Http\Controllers\Backend\DashboardController AS BackendDashboardController;
    use App\Http\Controllers\Backend\UserController AS BackendUserController;
    use App\Http\Controllers\Backend\DriverController AS BackendDriverController;
    use App\Http\Controllers\Backend\TripController AS BackendTripController;
    use App\Http\Controllers\Backend\TypeTripController AS BackendTypeTripController;
    use App\Http\Controllers\Backend\MyTripController AS BackendMyTripController;
    use App\Http\Controllers\Backend\PaymentRequestController AS BackendPaymentRequestController;
    use App\Http\Controllers\Backend\InvoiceController AS BackendInvoiceController;
    use App\Http\Controllers\Backend\EditProfileController AS BackendEditProfileController;
    use App\Http\Controllers\Backend\ChangePasswordController AS BackendChangePasswordController;
    // Report
    use App\Http\Controllers\Backend\Report\TripController AS BackendReportTripController;
    use App\Http\Controllers\Backend\Report\PaymentRequestController AS BackendReportPaymentRequestController;
    use App\Http\Controllers\Backend\Report\InvoiceController AS BackendReportInvoiceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    return redirect()->route('auth.login');
});

// Auth Routes
    // Login
    Route::get('/backend/login',  [LoginController::class, 'index'])->name('auth.login');
    Route::post('/auth/login/store',  [LoginController::class, 'store'])->name('auth.login.store');
    // Register
    Route::get('/backend/register',  [RegisterController::class, 'index'])->name('auth.register');
    Route::post('/auth/register/store',  [RegisterController::class, 'store'])->name('auth.register.store');
    // Forgot Password
    Route::get('/auth/forgot-password',  [ForgotPasswordController::class, 'index'])->name('auth.forgot-password');
    Route::post('/auth/forgot-password/store',  [ForgotPasswordController::class, 'store'])->name('auth.forgot-password.store');
    // Reset Password
    Route::get('/auth/reset-password/{token}',  [ResetPasswordController::class, 'index'])->name('auth.reset-password');
    Route::post('/auth/reset-password/{token}/store',  [ResetPasswordController::class, 'store'])->name('auth.reset-password.store');
    // Auth Logout
    Route::post('/auth/logout', [LogoutController::class, 'logout'])->name('auth.logout');

// Backend Routes
    Route::middleware('auth')->prefix('/backend/dashboard')->group(function(){
        Route::get('/', [BackendDashboardController::class, 'index'])->name('backend.dash.home');
        // Users
        Route::resource('/users', BackendUserController::class, ['as' => 'backend']);
        // Drivers
        Route::resource('/drivers', BackendDriverController::class, ['as' => 'backend']);
        // Type Trip
        Route::resource('/type-trip', BackendTypeTripController::class, ['as' => 'backend']);
        // Trip
        Route::resource('/trip', BackendTripController::class, ['as' => 'backend']);
        // My Trip
        Route::resource('/my-trip', BackendMyTripController::class, ['as' => 'backend']);
        // Payment Request
        Route::resource('/payment-request', BackendPaymentRequestController::class, ['as' => 'backend']);
        Route::get('/payment-request/{id}/proof-destroy', [BackendPaymentRequestController::class, 'proofDestroy'])->name('backend.dash.payment-request.proof-destroy');
        // Invoice
        Route::resource('/invoice', BackendInvoiceController::class, ['as' => 'backend']);

        // Report
        Route::prefix('/report')->group(function(){
            // Trip
            Route::get('/trip', [BackendReportTripController::class, 'index'])->name('backend.dash.report.trip.index');
            Route::get('/trip/download/pdf', [BackendReportTripController::class, 'downloadPDF'])->name('backend.dash.report.trip.download-pdf');
            // Payment Request
            Route::get('/payment-request', [BackendReportPaymentRequestController::class, 'index'])->name('backend.dash.report.payment-request.index');
            Route::get('/payment-request/download/pdf', [BackendReportPaymentRequestController::class, 'downloadPDF'])->name('backend.dash.report.payment-request.download-pdf');
            // Invoice
            Route::get('/invoice', [BackendReportInvoiceController::class, 'index'])->name('backend.dash.report.invoice.index');
            Route::get('/invoice/download/pdf', [BackendReportInvoiceController::class, 'downloadPDF'])->name('backend.dash.report.invoice.download-pdf');
        });
            
        // Edit Profile
        Route::get('/edit-profile', [BackendEditProfileController::class, 'index'])->name('backend.dash.edit-profile.index');
        Route::post('/edit-profile/update', [BackendEditProfileController::class, 'update'])->name('backend.dash.edit-profile.update');
        // Change Password
        Route::get('/change-password', [BackendChangePasswordController::class, 'index'])->name('backend.dash.change-password.index');
        Route::post('/change-password/update', [BackendChangePasswordController::class, 'update'])->name('backend.dash.change-password.update');
    });

    Route::post('/upload-transport-price-list', [UploadTransportPriceList::class, 'upload'])->name('backend.dash.upload-transport-price-list');