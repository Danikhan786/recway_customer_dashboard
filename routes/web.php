<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReviewersController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EmailSettingsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

Route::get('check-locale', function () {
    return Session::get('locale', 'No locale set');
});



Route::middleware(['setlocale'])->group(function () {
    // Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/set-language', function (Illuminate\Http\Request $request) {
        session(['lang_pair' => $request->lang_pair]);
        return response()->json(['status' => 'success']);
    });
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/verify-otp', [AuthController::class, 'showOtpVerificationForm'])->name('verify.otp')->middleware('guest');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('account', [UserController::class, 'edit'])->name('account')->middleware('auth');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update')->middleware('auth');

    // Show the form for requesting a password reset link
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('forgot-password');

    // Handle the form submission and send the password reset link
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('forgot-password.send');

    // Show the form for setting a new password (after clicking the link in email)
    Route::get('change-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('change-password');

    // Handle the form submission for resetting the password
    Route::post('change-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');


    Route::get('/signup', [AuthController::class, 'signup'])->name('login');

    Route::get('/', function () {
        return view('login');
    })->name('new');
    Route::get('/verify', function () {
        return view('verify');
    })->name('verify');

    Route::get('/forgot-password', function () {
        return view('forgot-password');
    })->name('forgot-password');

    Route::middleware(['auth'])->group(function () {

        Route::get('lang-set', function () {
            $lang = request()->query('lang');
            Session::put('locale', $lang); // Store the language in the session
            App::setLocale($lang); // Set the language for the current request
            return redirect()->back(); // Redirect back to the previous page
        })->name('lang-set');


        //    Route::get('lang-1/{lang-1}', function ($lang-1) {
//        // Check if the locale is supported
//        $lang-1 = request()->lang-1;
//        App::setLocale($lang-1);
//        return redirect()->back();
//
//    })->name('lang-1.switch');


        Route::get('/dashboard', [CandidateController::class, 'recentOrders'])->name('dashboard');

        Route::get('/order', [CreateOrderController::class, 'view'])->name('create_order');
        Route::get('/create_order', [CreateOrderController::class, 'index'])->name('index');
        Route::post('/submit-order', [CreateOrderController::class, 'submitOrder'])->name('submit.order');
        Route::post('/cancel-order', [CreateOrderController::class, 'cancel_order'])->name('cancel_order');
        Route::post('/change-status', [CreateOrderController::class, 'change_status'])->name('change_status');

        Route::get('/services', [CreateOrderController::class, 'services'])->name('services');
        Route::post('/services-get', [CreateOrderController::class, 'get_services'])->name('service.get');
        Route::post('/get-service-form', [CreateOrderController::class, 'fetch_form'])->name('service.get_form');


        Route::get('/orders', [CandidateController::class, 'showOrders'])->name('orders');
        Route::get('/view-order', [CandidateController::class, 'viewOrder'])->name('viewOrder');
        Route::get('/edit-order', [CandidateController::class, 'editOrder'])->name('editOrder');
        Route::post('/update-order', [CreateOrderController::class, 'updateOrder'])->name('updateOrder');
        Route::post('/update-status', [CandidateController::class, 'showDataByStatus'])->name('update.status');
        Route::post('/send_security_report', [CandidateController::class, 'uploadPDF'])->name('upload_report');

        Route::get('/add-reviewer', [ReviewersController::class, 'create'])->name('reviewer.create');
        Route::post('/add-reviewer', [ReviewersController::class, 'store'])->name('reviewer.store');
        Route::get('/reviewers', [ReviewersController::class, 'index'])->name('reviewers');
        Route::get('/edit-reviewer/{id}', [ReviewersController::class, 'edit'])->name('reviewers.edit');
        Route::put('/reviewers/{id}', [ReviewersController::class, 'update'])->name('reviewers.update');

        Route::get('/history', [HistoryController::class, 'index'])->name('history');
        Route::post('/billing/update', [UserController::class, 'billing_update'])->name('billing.update');
        Route::get('/email_settings', [EmailSettingsController::class, 'index'])->name('email_settings');
        Route::post('/allow_email', [EmailSettingsController::class, 'allow_email'])->name('allow_email');

    });

    //Route::get('/test', function () {
//    return view('test');
//})->name('test');
    Route::get('clear-cache', function () {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return 'Cache cleared';
    });

    Route::get('test/', function (Request $request) {
        $lang = $request->lang ? $request->lang : 'swg';
        App::setLocale($lang);
        return __('messages.dashboard');
    });

});
