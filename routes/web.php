<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\EmailLogExpiredController;
use App\Http\Controllers\FeaturedDomainController;
use App\Http\Controllers\HelpdeskLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuspendQueueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'landing'])->name('landing');
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::middleware(['auth', 'role:super_admin|pandi|helpdesk'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/domain', [DomainController::class, 'index'])->name('domain.index');
    Route::get('/featured-domains', [FeaturedDomainController::class, 'index'])->name('featured-domain.index');
    Route::get('/domain/export/csv', [DomainController::class, 'export'])->name('domain.export');
    Route::get('/domain/search', [DomainController::class, 'search'])->name('domain.search');
    Route::get('/domain/{id}', [DomainController::class, 'show'])->name('domain.show');
    Route::get('/email-log-expired', [EmailLogExpiredController::class, 'index'])->name('email-log-expired.index');
    Route::get('/email-log-expired/export/csv', [EmailLogExpiredController::class, 'export'])->name('email-log-expired.export');
    Route::get('/helpdesk-log', [HelpdeskLogController::class, 'index'])->name('helpdesk-log.index');
    Route::get('/helpdesk-log/create', [HelpdeskLogController::class, 'create'])->name('helpdesk-log.create');
    Route::post('/helpdesk-log', [HelpdeskLogController::class, 'store'])->name('helpdesk-log.store');
    Route::get('/helpdesk-log/export/csv', [HelpdeskLogController::class, 'export'])->name('helpdesk-log.export');
    Route::post('/helpdesk-log/import/csv', [HelpdeskLogController::class, 'importCsv'])->name('helpdesk-log.import');
    Route::get('/helpdesk-log/{id}/edit', [HelpdeskLogController::class, 'edit'])->name('helpdesk-log.edit');
    Route::put('/helpdesk-log/{id}', [HelpdeskLogController::class, 'update'])->name('helpdesk-log.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/suspend-queue', [SuspendQueueController::class, 'index'])->name('suspend-queue.index');
    Route::get('/suspend-queue/export/csv', [SuspendQueueController::class, 'export'])->name('suspend-queue.export');
    Route::post('/suspend-queue/{id}/suspend', [SuspendQueueController::class, 'suspend'])->name('suspend-queue.suspend');
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/activity-log/export/csv', [ActivityLogController::class, 'export'])->name('activity-log.export');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
