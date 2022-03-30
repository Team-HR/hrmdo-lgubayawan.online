<?php
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
use App\Http\Controllers\PMS\RatingScaleMatrixController;


Route::get('/pms/rsm',[RatingScaleMatrixController:: class, 'index'])->middleware(['auth','rsm'])->name('rsm');

Route::get('/pms/rsm/{id}',[RatingScaleMatrixController:: class, 'getRatingScaleMatrix'])->middleware(['auth','rsm']);

Route::post('/pms/rsm/add_new_mfo',[RatingScaleMatrixController:: class, 'add_new_mfo'])->middleware(['auth','rsm']);



Route::get('/pms/pcr', function () {
    return Inertia::render('PMS/PCR/PerformanceCommitmentReport');
})->middleware(['auth'])->name('pcr');

Route::get('/pms/rpc', function () {
    return Inertia::render('PMS/RPC/ReviewPerformanceCommitment');
})->middleware(['auth'])->name('rpc');

Route::get('/pms/pmt', function () {
    return Inertia::render('PMS/PMT/PerformanceManagementTeam');
})->middleware(['auth'])->name('pmt');
