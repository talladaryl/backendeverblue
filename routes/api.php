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
use App\Http\Controllers\Api\AIImageController;
use App\Http\Controllers\Api\BulkSendController;
use App\Http\Controllers\Api\OrganizationController;

// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Resources
Route::apiResource('organizations', OrganizationController::class);
Route::apiResource('templates', TemplateController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('guests', GuestController::class);
Route::apiResource('rsvps', RsvpController::class);
Route::apiResource('mailings', MailingController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('assets', AssetController::class);
Route::apiResource('payments', PaymentController::class);

// Event routes
Route::post('events/{event}/change-status', [EventController::class, 'changeStatus']);
Route::post('events/{event}/archive', [EventController::class, 'archive']);
Route::post('events/{event}/unarchive', [EventController::class, 'unarchive']);
Route::get('events/archived/list', [EventController::class, 'archived']);
Route::get('events/active/list', [EventController::class, 'active']);
Route::get('events/upcoming/list', [EventController::class, 'upcoming']);
Route::get('events/past/list', [EventController::class, 'past']);
Route::get('events/statistics/all', [EventController::class, 'statistics']);

// Mailing routes
Route::post('mailings/{mailing}/send', [MailingController::class, 'send']);
Route::post('mailings/{mailing}/test', [MailingController::class, 'sendTest']);
Route::get('events/{event}/mailings/statistics', [MailingController::class, 'statistics']);
Route::post('mailings/bulk/email', [MailingController::class, 'sendBulkEmail']);
Route::post('mailings/bulk/whatsapp', [MailingController::class, 'sendBulkWhatsApp']);

// Guest routes
Route::post('events/{event}/guests/import', [GuestController::class, 'import']);

// Bulk Send routes
Route::post('bulk-send', [BulkSendController::class, 'send']);
Route::get('bulk-send/preview/{event}', [BulkSendController::class, 'preview']);
Route::get('bulk-send/info/{event}', [BulkSendController::class, 'info']);

// Organization routes
Route::get('organizations/{organization}/events', [OrganizationController::class, 'events']);
Route::get('organizations/{organization}/statistics', [OrganizationController::class, 'statistics']);
Route::get('my-organizations', [OrganizationController::class, 'myOrganizations']);

// AI Image Generation
Route::prefix('aiimage')->middleware('auth:sanctum')->group(function () {
    Route::get('/versions', [AIImageController::class, 'versions']);
    Route::get('/check-availability', [AIImageController::class, 'checkActiveGeneration']);
    Route::post('/generate-image', [AIImageController::class, 'generateImage']);
    Route::get('/recent-images', [AIImageController::class, 'getRecentImages']);
    Route::get('/usage', [AIImageController::class, 'getUserUsage']);
    Route::get('/images/{generatedImage}', [AIImageController::class, 'getImage']);
    Route::delete('/images/{generatedImage}', [AIImageController::class, 'deleteImage']);
});
