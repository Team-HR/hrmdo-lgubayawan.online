<?php
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
use App\Http\Controllers\PMS\RatingScaleMatrixController;

Route::middleware(['auth','rsm'])->group(function () {


    Route::get('/pms/rsm',[RatingScaleMatrixController:: class, 'index'])->name('rsm');

    Route::get('/pms/rsm/{id}',[RatingScaleMatrixController:: class, 'show']);
    
    Route::post('/pms/rsm/addNewMfo',[RatingScaleMatrixController:: class, 'addNewMfo']);
    
    Route::post('/pms/rsm/saveEditMfo',[RatingScaleMatrixController:: class, 'saveEditMfo']);
    
    Route::get('/pms/rsm/getSuccessIndicator/{id}',[RatingScaleMatrixController:: class, 'getSuccessIndicator']);
    
    Route::post('/pms/rsm/saveSuccessIndicator',[RatingScaleMatrixController:: class, 'saveSuccessIndicator']);
    
    Route::post('/pms/rsm/getMfoParents',[RatingScaleMatrixController:: class, 'getMfoParents']);
    
    Route::post('/pms/rsm/changeMfoParent',[RatingScaleMatrixController:: class, 'changeMfoParent']);
    
    Route::post('/pms/rsm/addSubFunction',[RatingScaleMatrixController:: class, 'addSubFunction']);
    
    Route::post('/pms/rsm/removeMfoParent',[RatingScaleMatrixController:: class, 'removeMfoParent']);
    
    Route::post('/pms/rsm/delete',[RatingScaleMatrixController:: class, 'delete']);
    
});














Route::get('/pms/pcr', function () {
    return Inertia::render('PMS/PCR/PerformanceCommitmentReport');
})->middleware(['auth'])->name('pcr');

Route::get('/pms/rpc', function () {
    return Inertia::render('PMS/RPC/ReviewPerformanceCommitment');
})->middleware(['auth'])->name('rpc');

Route::get('/pms/pmt', function () {
    return Inertia::render('PMS/PMT/PerformanceManagementTeam');
})->middleware(['auth'])->name('pmt');