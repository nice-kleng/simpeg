<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Sosmed\ReportTikTokController;
use App\Http\Controllers\Sosmed\ReportTikTokLiveController;
use App\Http\Controllers\Sosmed\SosmedController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\Sosmed\TimelineInstagramController;
use App\Http\Controllers\Sosmed\TimelineTiktokController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthenticateController::class, 'login'])->name('login');
Route::post('login', [AuthenticateController::class, 'authenticate']);
Route::post('logout', [AuthenticateController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    // Route::controller(SuperadminController::class)->group(function () {
    //     Route::get('superadmin/dashboard', 'index')->name('superadmin.dashboard');
    // });
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::get('/detail-project/{user_id}', 'detailProject')->name('detail.project');
        Route::get('project/timeline/ig', 'timelineIg')->name('project.timeline.ig');
        Route::get('project/timeline/tiktok', 'timelineTiktok')->name('project.timeline.tiktok');
        Route::get('project/tiktok/live', 'tiktokLive')->name('project.tiktok.live');
    });

    Route::resources([
        '/jabatan' => JabatanController::class,
        '/pegawai' => PegawaiController::class,
        '/product' => ProductController::class,
        '/mitra' => MitraController::class,
    ]);

    Route::controller(TimelineInstagramController::class)->group(function () {
        Route::get('timelineInstagram', 'index')->name('timelineInstagram.index');
        Route::get('timelineInstagram/create', 'create')->name('timelineInstagram.create');
        Route::post('timelineInstagram/store', 'store')->name('timelineInstagram.store');
        Route::get('timelineInstagram/{timelineInstagram}/edit', 'edit')->name('timelineInstagram.edit');
        Route::put('timelineInstagram/{timelineInstagram}', 'update')->name('timelineInstagram.update');
        Route::delete('timelineInstagram/{timelineInstagram}', 'destroy')->name('timelineInstagram.destroy');

        Route::get('timelineInstagram/{timelineInstagram}/report', 'report')->name('timelineInstagram.report');
        Route::get('timelineInstagram/{timelineInstagram}/editReport', 'editReport')->name('timelineInstagram.editReport');
        Route::post('timelineInstagram/storeReport', 'storeReport')->name('timelineInstagram.storeReport');
        Route::put('timelineInstagram/{timelineInstagram}/updateReport', 'updateReport')->name('timelineInstagram.updateReport');

        Route::post('timelineInstagram/export', 'exportExcel')->name('timelineInstagram.exportExcel');
    });

    // Route::controller(ReportTikTokController::class)->group(function () {
    //     Route::get('reportTikTok', 'index')->name('reportTikTok.index');
    //     Route::get('reportTikTok/create', 'create')->name('reportTikTok.create');
    //     Route::post('reportTikTok/store', 'store')->name('reportTikTok.store');
    //     Route::get('reportTikTok/{reportTikTok}/edit', 'edit')->name('reportTikTok.edit');
    //     Route::put('reportTikTok/{reportTikTok}', 'update')->name('reportTikTok.update');
    //     Route::delete('reportTikTok/{reportTikTok}', 'destroy')->name('reportTikTok.destroy');
    //     Route::post('reportTikTok/export', 'export')->name('reportTikTok.export');
    // });

    Route::controller(TimelineTiktokController::class)->group(function () {
        Route::get('timelineTikTok', 'index')->name('timelineTikTok.index');
        Route::get('timelineTikTok/create', 'create')->name('timelineTikTok.create');
        Route::post('timelineTikTok/store', 'store')->name('timelineTikTok.store');
        Route::get('timelineTikTok/{timelineTiktok}/edit', 'edit')->name('timelineTikTok.edit');
        Route::put('timelineTikTok/{timelineTiktok}', 'update')->name('timelineTikTok.update');
        Route::delete('timelineTikTok/{timelineTiktok}', 'destroy')->name('timelineTikTok.destroy');

        Route::get('timelineTikTok/{timelineTiktok}/report/create', 'reportCreate')->name('timelineTikTok.reportCreate');
        Route::post('timelineTikTok/report/store', 'reportStore')->name('timelineTikTok.reportStore');
        Route::get('timelineTikTok/{timelineTiktok}/report/edit', 'editReport')->name('timelineTikTok.editReport');
        Route::put('timelineTikTok/{timelineTiktok}/report/update', 'updateReport')->name('timelineTikTok.updateReport');
        Route::get('timelineTikTok/{timelineTiktok}/report/detail', 'detailReport')->name('timelineTikTok.detailReport');
        Route::delete('timelineTikTok/{timelineTiktok}/report/destroy', 'destroyReport')->name('timelineTikTok.destroyReport');
        Route::post('timelineTikTok/report/export', 'exportReport')->name('timelineTikTok.exportReport');
    });

    Route::controller(ReportTikTokLiveController::class)->group(function () {
        Route::get('reportTikTokLive', 'index')->name('reportTikTokLive.index');
        Route::get('reportTikTokLive/create', 'create')->name('reportTikTokLive.create');
        Route::post('reportTikTokLive/store', 'store')->name('reportTikTokLive.store');
        Route::get('reportTikTokLive/{reportTikTokLive}/edit', 'edit')->name('reportTikTokLive.edit');
        Route::put('reportTikTokLive/{reportTikTokLive}', 'update')->name('reportTikTokLive.update');
        Route::delete('reportTikTokLive/{reportTikTokLive}', 'destroy')->name('reportTikTokLive.destroy');
        Route::post('reportTikTokLive/export', 'export')->name('reportTikTokLive.export');
    });

    // Route::controller(SosmedController::class)->group(function () {
    //     Route::get('sosmed/dashboard', 'index')->name('sosmed.dashboard');
    // });
});
