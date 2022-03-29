<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/pms/pcr', function () {
    return Inertia::render('PMS/PCR/PerformanceCommitmentReport');
})->middleware(['auth'])->name('pcr');

Route::get('/pms/rpc', function () {
    return Inertia::render('PMS/RPC/ReviewPerformanceCommitment');
})->middleware(['auth'])->name('rpc');

Route::get('/pms/pmt', function () {
    return Inertia::render('PMS/PMT/PerformanceManagementTeam');
})->middleware(['auth'])->name('pmt');

Route::get('/pms/rsm', function () {
    return Inertia::render('PMS/RSM/RatingScaleMatrix');
})->middleware(['auth','rsm'])->name('rsm');



require __DIR__.'/auth.php';
