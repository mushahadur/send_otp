<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\AuthSMS\AuthOtpController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// SMS OTP Route
Route::controller(App\Http\Controllers\AuthSMS\AuthOtpController::class)->group(function(){
    Route::get('/otp/login', 'login')->name('otp.login');
    Route::post('/otp/generate', 'generate')->name('otp.generate');
    Route::get('/otp/verificaton{user_id}', 'verificaton')->name('otp.verification');
    Route::post('/otp/login-get', 'loginWithOtp')->name('otp.getLogin');
});










Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// Follow This Video => https://www.youtube.com/@ProgrammingExperience/search?query=otplogin