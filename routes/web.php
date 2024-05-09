<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Direktur\ManajemenReimbursementController;
use App\Http\Controllers\Direktur\ManajemenUserController;
use App\Http\Controllers\Finance\ManajemenReimbursementController as FinanceManajemenReimbursementController;
use App\Http\Controllers\Staff\ReimbursementController;
use Illuminate\Support\Facades\Route;

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

Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
     Route::get('logout', 'logout')->name('logout');
});

Route::group(['middleware' => ['auth']],function () {
    Route::group(['middleware' => ['direktur']],function () {
        Route::controller(ManajemenUserController::class)->group(function() {
            Route::get('/manajemen-user', 'index')->name('manajemen-user');
            Route::get('/list-data-user', 'listDataUser')->name('list-data-user');
            Route::get('/find-data-user', 'findDataUserByID')->name('find-data-user');
            Route::post('/store-user', 'storeUser')->name('store-user');
            Route::post('/edit-user', 'editUser')->name('edit-user');
            Route::delete('/delete-user/{id}', 'deleteUser')->name('delete-user');
        });

        Route::controller(ManajemenReimbursementController::class)->group(function() {
            Route::get('/manajemen-reimbursement-direktur', 'index')->name('manajemen-reimbursement-direktur');
            Route::get('/list-data-reimbursement-user', 'listDataReimbursementUser')->name('list-data-reimbursement-user');
            Route::get('/find-data-reimbursement-user', 'findDataReimbursementUserByID')->name('find-data-reimbursement-user');
            Route::post('/verifikasi-reimbursement-user', 'Verifikasi')->name('verifikasi-reimbursement-user');
            Route::post('/tolak-reimbursement-user', 'Tolak')->name('tolak-reimbursement-user');
        });
    });
    Route::group(['middleware' => ['finance']], function () {
        Route::controller(FinanceManajemenReimbursementController::class)->group(function() {
            Route::get('/manajemen-reimbursement-finance', 'index')->name('manajemen-reimbursement-finance');
            Route::get('/list-data-reimbursement-user-finance', 'listDataReimbursementUser')->name('list-data-reimbursement-user-finance');
            Route::get('/find-data-reimbursement-user-finance', 'findDataReimbursementUserByID')->name('find-data-reimbursement-user-finance');
            Route::post('/verifikasi-reimbursement-user-finance', 'Verifikasi')->name('verifikasi-reimbursement-user-finance');
            Route::post('/tolak-reimbursement-user-finance', 'Tolak')->name('tolak-reimbursement-user-finance');
        });
    });

    Route::group(['middleware' => ['staff']],function () {
        Route::controller(ReimbursementController::class)->group(function() {
            Route::get('/data-pengajuan-reimbursement', 'index')->name('data-pengajuan-reimbursement');
            Route::get('/list-data-reimbursement', 'listDataReimbursement')->name('list-data-reimbursement');
            Route::get('/find-data-reimbursement', 'findDataReimbursementByID')->name('find-data-reimbursement');
            Route::post('/store-reimbursement', 'storeReimbursement')->name('store-reimbursement');
            Route::delete('/delete-reimbursement/{id}', 'deleteReimbursement')->name('delete-reimbursement');
        });
    });
});

