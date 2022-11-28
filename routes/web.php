<?php

use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Home\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home\DeviceUser;
use App\Http\Livewire\Home\MasterUser;
use App\Http\Livewire\Home\UserDevice;
use App\Http\Livewire\Home\MasterAdmin;
use App\Http\Livewire\Home\MasterDevice;
use App\Http\Livewire\Home\MasterOperator;
use App\Http\Livewire\Home\DataDevices;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', Dashboard::class)->name('home');
    Route::get('/master-admin', MasterAdmin::class)->name('master-admin');
    Route::get('/master-user', MasterUser::class)->name('master-user');
    Route::get('/master-operator', MasterOperator::class)->name('master-operator');
    Route::get('/master-device', MasterDevice::class)->name('master-device');
    Route::get('/user-device', DeviceUser::class)->name('user-device');
    Route::get('/data-device', DataDevices::class)->name('data-device');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});
