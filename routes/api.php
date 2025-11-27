<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TemplateController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\RsvpController;
use App\Http\Controllers\Api\MailingController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\PaymentController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
});

// api resource routes
Route::apiResource('templates', TemplateController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('guests', GuestController::class);
Route::apiResource('rsvps', RsvpController::class);
Route::apiResource('mailings', MailingController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('assets', AssetController::class);
Route::apiResource('payments', PaymentController::class);

// Event specific routes
Route::post('events/{event}/change-status', [EventController::class, 'changeStatus'])->name('events.changeStatus');
Route::post('events/{event}/archive', [EventController::class, 'archive'])->name('events.archive');
Route::post('events/{event}/unarchive', [EventController::class, 'unarchive'])->name('events.unarchive');
Route::get('events/archived/list', [EventController::class, 'archived'])->name('events.archived');
Route::get('events/active/list', [EventController::class, 'active'])->name('events.active');
Route::get('events/upcoming/list', [EventController::class, 'upcoming'])->name('events.upcoming');
Route::get('events/past/list', [EventController::class, 'past'])->name('events.past');
Route::get('events/statistics/all', [EventController::class, 'statistics'])->name('events.statistics');

// Mailing specific routes
Route::post('mailings/{mailing}/send', [MailingController::class, 'send'])->name('mailings.send');
Route::post('mailings/{mailing}/test', [MailingController::class, 'sendTest'])->name('mailings.test');
Route::get('events/{event}/mailings/statistics', [MailingController::class, 'statistics'])->name('mailings.statistics');
Route::post('mailings/bulk/email', [MailingController::class, 'sendBulkEmail'])->name('mailings.bulkEmail');
Route::post('mailings/bulk/whatsapp', [MailingController::class, 'sendBulkWhatsApp'])->name('mailings.bulkWhatsApp');

Route::post('events/{event}/guests/import', [GuestController::class, 'import'])->name('guests.import');

// api routes for AI Image Generation
Route::prefix('aiimage')->middleware('auth:sanctum')->group(function () {
    Route::get('/versions', [AIImageController::class, 'versions']);
    Route::get('/check-availability', [AIImageController::class, 'checkActiveGeneration']);
    Route::post('/generate-image', [AIImageController::class, 'generateImage']);
    Route::get('/recent-images', [AIImageController::class, 'getRecentImages']);
    Route::get('/usage', [AIImageController::class, 'getUserUsage']);
    Route::get('/images/{generatedImage}', [AIImageController::class, 'getImage']);
    Route::delete('/images/{generatedImage}', [AIImageController::class, 'deleteImage']);
});

// Import AIImageController
use App\Http\Controllers\Api\AIImageController;