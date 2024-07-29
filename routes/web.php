<?php

use App\Http\Controllers\CashRequestController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonthlyTendersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeeklyReportController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return Inertia::render('Admin/Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::controller(UserController::class)->middleware('user-access:admin,manager')->name('user.')->group(function () {
        Route::get('/users', 'index')->name('index');
        Route::post('/users', 'store')->name('store');
        Route::put('/users/{id}', 'update')->name('update');
        Route::delete('/users/{id}', 'destroy')->name('destroy');
    });
    Route::controller(ContractController::class)->name('contract.')->group(function () {
        Route::get('/contracts', 'index')->name('index');
        Route::post('/contracts', 'store')->name('store')->middleware('user-access:procurement');
        Route::put('/contracts/{id}', 'update')->name('update')->middleware('user-access:procurement');
        Route::delete('/contracts/{id}', 'destroy')->name('destroy')->middleware('user-access:procurement');

        Route::get('/active-contracts', 'activeContracts')->name('activeContracts');
        Route::get('/contracts/{id}', 'show')->name('show');

    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(MonthlyTendersController::class)->prefix('monthly-tenders')->name('monthly-tenders.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

    Route::resource('/tenders', TenderController::class);
    Route::get('/tenders-new', [TenderController::class, 'new_tenders'])->name('tenders.new');
    Route::get('/tenders-list', [TenderController::class, 'tenders'])->name('tenders.list');

    Route::controller(CashRequestController::class)->prefix('cash-request')->name('cashRequest.')->group(function () {
        Route::get('/field', 'fieldRequests')->name('field');
        Route::get('/manager', 'managerRequests')->name('manager');
        Route::get('/finance', 'financeRequests')->name('finance');

        Route::post('/cashRequest/{contract}', 'cashRequest')->name('store');
        Route::put('/cashRequest/{contract}', 'cashRequestUpdate')->name('update');
        Route::delete('/cashRequest/{contract}', 'cashRequestDelete')->name('destroy');
        Route::put('/cashRequest/approve/{contract}', 'approve')->name('approve');
        Route::put('/cashRequest/reject/{contract}', 'reject')->name('reject');
        Route::put('/cashRequest/closing/{contract}', 'closing')->name('closing');
        Route::put('/cashRequest/finance-approve/{contract}', 'financeApprove')->name('financeApprove');
    });

    Route::resource('/weekly-reports', WeeklyReportController::class);
    Route::get('/weekly-reports-list', [WeeklyReportController::class, 'reports_list'])->name('weekly_reports.list');;
    Route::put('/weekly-reports/approve/{id}', [WeeklyReportController::class, 'approve'])->name('weekly_reports.approve');;
});

require __DIR__ . '/auth.php';
