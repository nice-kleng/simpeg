<?php

use App\Exports\TurlapExport;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\Marketing\BrandController;
use App\Http\Controllers\Marketing\LeadsController;
use App\Http\Controllers\Marketing\SumberMarketingController;
use App\Http\Controllers\Marketing\TurlapController;
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
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('turlap/export', function () {
    return Excel::download(new TurlapExport(), 'turlap.xlsx');
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

    Route::controller(SumberMarketingController::class)->group(function () {
        // Route::get('sumberMarketing', 'index')->name('sumberMarketing.index');
        Route::get('sumberMarketing/create', 'create')->name('sumberMarketing.create');
        Route::post('sumberMarketing/store', 'store')->name('sumberMarketing.store');
        Route::get('sumberMarketing/{sumberMarketing}/edit', 'edit')->name('sumberMarketing.edit');
        Route::put('sumberMarketing/{sumberMarketing}', 'update')->name('sumberMarketing.update');
        Route::delete('sumberMarketing/{sumberMarketing}', 'destroy')->name('sumberMarketing.destroy');
    });

    Route::controller(TurlapController::class)->group(function () {
        Route::get('turlap', 'index')->name('turlap.index');
        Route::get('turlap/{id}', 'detailTurlapByArea')->name('turlap.detailTurlapByArea');
        Route::post('turlap/store', 'store')->name('turlap.store');
        Route::get('turlap/{id}/edit', 'edit')->name('turlap.edit');
        Route::put('turlap/{id}', 'update')->name('turlap.update');
        Route::delete('turlap/{id}', 'destroy')->name('turlap.destroy');
        Route::get('turlap/{id}/followUp', 'followUp')->name('turlap.followUp');
        Route::post('turlap/{id}/followUp/store', 'followUpStore')->name('turlap.followUpStore');
        Route::get('turlap/{id}/followUp/edit', 'followUpEdit')->name('turlap.followUpEdit');
        Route::put('turlap/{id}/followUp/update', 'followUpUpdate')->name('turlap.followUpUpdate');
        Route::delete('turlap/{id}/followUp/destroy', 'followUpDestroy')->name('turlap.followUpDestroy');
        Route::get('data-turlap', 'tampilTurlap')->name('turlap.tampilTurlap');
        Route::get('/report-turlap', 'preview')->name('turlap.preview');
        Route::post('/preview-turlap', 'preview')->name('turlap.preview.data');
        Route::post('/export-turlap', 'export')->name('turlap.export.excel');
    });

    Route::controller(LeadsController::class)->group(function () {
        Route::get('leads', 'index')->name('leads.index');
        Route::get('leads/{id}', 'detailLeadsByArea')->name('leads.detailLeadsByArea');
        Route::post('leads/store', 'store')->name('leads.store');
        Route::get('leads/{id}/edit', 'edit')->name('leads.edit');
        Route::put('leads/{id}', 'update')->name('leads.update');
        Route::delete('leads/{id}', 'destroy')->name('leads.destroy');
        Route::get('leads/{id}/followUp', 'followUp')->name('leads.followUp');
        Route::post('leads/{id}/followUp/store', 'followUpStore')->name('leads.followUpStore');
        Route::get('leads/{id}/followUp/edit', 'followUpEdit')->name('leads.followUpEdit');
        Route::put('leads/{id}/followUp/update', 'followUpUpdate')->name('leads.followUpUpdate');
        Route::delete('leads/{id}/followUp/destroy', 'followUpDestroy')->name('leads.followUpDestroy');
        Route::get('data-leads', 'tampilLeads')->name('leads.tampilLeads');
    });

    Route::controller(BrandController::class)->group(function () {
        Route::get('brand', 'index')->name('brand.index');
        Route::get('brand/{id}', 'detailBrandByArea')->name('brand.detailBrandByArea');
        Route::post('brand/store', 'store')->name('brand.store');
        Route::get('brand/{id}/edit', 'edit')->name('brand.edit');
        Route::put('brand/{id}', 'update')->name('brand.update');
        Route::delete('brand/{id}', 'destroy')->name('brand.destroy');
        Route::get('brand/{id}/followUp', 'followUp')->name('brand.followUp');
        Route::post('brand/{id}/followUp/store', 'followUpStore')->name('brand.followUpStore');
        Route::get('brand/{id}/followUp/edit', 'followUpEdit')->name('brand.followUpEdit');
        Route::put('brand/{id}/followUp/update', 'followUpUpdate')->name('brand.followUpUpdate');
        Route::delete('brand/{id}/followUp/destroy', 'followUpDestroy')->name('brand.followUpDestroy');
        Route::get('data-brand', 'tampilBrand')->name('brand.tampilBrand');
    });
});
