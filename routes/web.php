<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use Illuminate\Http\Request;
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

Route::get('/getRatingPeriods', function () {
    $periods = App\Models\RatingPeriod::select('*')->orderByDesc('year')->get();
    $data = [];
    foreach ($periods as $period) {
        if (!in_array($period['year'], array_column($data, 'year'))) {
            $data[] = [
                'year' => $period['year'],
                'first' => App\Models\RatingPeriod::select('*')->where('year', '=', $period['year'])->where('period', '=', 1)->first(),
                'second' => App\Models\RatingPeriod::select('*')->where('year', '=', $period['year'])->where('period', '=', 2)->first()
            ];
        }
    }
    return response()->json($data);
})->middleware(['auth']);


Route::post('/employees', function (Request $request) {
    $items = [];

    $excepts = $request->excepts;
    foreach ($excepts as $key => $employee) {
        $excepts[$key] = $employee['id'];
    }

    $items = App\Models\Employee::select('*')
        ->where('last_name', 'like', '%' . $request->name . '%')
        ->orWhere('first_name', 'like', '%' . $request->name . '%')
        ->get();

    $data = [];
    foreach ($items as $key => $employee) {
        if (!in_array($employee->id, $excepts)) {
            $data[] = [
                'id' => $employee->id,
                'full_name' => $employee->full_name,
            ];
        }
    }

    return response()->json($data);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/pms.php';
