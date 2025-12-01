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

// ---------------------------------------------
// Auth routes (sans Sanctum)
// ---------------------------------------------
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// ---------------------------------------------
// API Resources (libres d'accès, sans auth)
// ---------------------------------------------
Route::apiResource('templates', TemplateController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('guests', GuestController::class);
Route::apiResource('rsvps', RsvpController::class);
Route::apiResource('mailings', MailingController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('assets', AssetController::class);
Route::apiResource('payments', PaymentController::class);

// ---------------------------------------------
// Events extra routes
// ---------------------------------------------
Route::post('events/{event}/change-status', [EventController::class, 'changeStatus']);
Route::post('events/{event}/archive', [EventController::class, 'archive']);
Route::post('events/{event}/unarchive', [EventController::class, 'unarchive']);

Route::get('events/archived/list', [EventController::class, 'archived']);
Route::get('events/active/list', [EventController::class, 'active']);
Route::get('events/upcoming/list', [EventController::class, 'upcoming']);
Route::get('events/past/list', [EventController::class, 'past']);
Route::get('events/statistics/all', [EventController::class, 'statistics']);

// ---------------------------------------------
// Mailing extra routes
// ---------------------------------------------
Route::post('mailings/{mailing}/send', [MailingController::class, 'send']);
Route::post('mailings/{mailing}/test', [MailingController::class, 'sendTest']);
Route::get('events/{event}/mailings/statistics', [MailingController::class, 'statistics']);
Route::post('mailings/bulk/email', [MailingController::class, 'sendBulkEmail']);
Route::post('mailings/bulk/whatsapp', [MailingController::class, 'sendBulkWhatsApp']);

Route::post('events/{event}/guests/import', [GuestController::class, 'import']);

// ---------------------------------------------
// AI Image Generation (sans auth)
// ---------------------------------------------
Route::prefix('aiimage')->group(function () {
    Route::get('/versions', [AIImageController::class, 'versions']);
    Route::get('/check-availability', [AIImageController::class, 'checkActiveGeneration']);
    Route::post('/generate-image', [AIImageController::class, 'generateImage']);
    Route::get('/recent-images', [AIImageController::class, 'getRecentImages']);
    Route::get('/usage', [AIImageController::class, 'getUserUsage']);
    Route::get('/images/{generatedImage}', [AIImageController::class, 'getImage']);
    Route::delete('/images/{generatedImage}', [AIImageController::class, 'deleteImage']);
});

// Import additional controllers
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\BulkSendController;
use App\Http\Controllers\Api\TwilioController;

// Organizations routes
Route::apiResource('organizations', OrganizationController::class);
Route::get('organizations/{organization}/events', [OrganizationController::class, 'events']);
Route::get('organizations/{organization}/statistics', [OrganizationController::class, 'statistics']);
Route::get('my-organizations', [OrganizationController::class, 'myOrganizations']);

// Guests with event filter
Route::get('guests', [GuestController::class, 'index']);

// Mailings with event filter
Route::get('mailings', [MailingController::class, 'index']);

// Bulk Send routes
Route::post('bulk-send', [BulkSendController::class, 'store']);
Route::get('bulk-send', [BulkSendController::class, 'index']);
Route::get('bulk-send/{bulkSend}/status', [BulkSendController::class, 'status']);
Route::post('bulk-send/{bulkSend}/cancel', [BulkSendController::class, 'cancel']);
Route::post('bulk-send/{bulkSend}/retry', [BulkSendController::class, 'retry']);

// Twilio routes
Route::post('twilio/send-{channel}', [TwilioController::class, 'send']);
Route::post('twilio/send-bulk', [TwilioController::class, 'sendBulk']);
Route::get('twilio/history', [TwilioController::class, 'history']);
Route::get('twilio/status/{messageSid}', [TwilioController::class, 'messageStatus']);
Route::get('twilio/bulk/{bulkId}/status', [TwilioController::class, 'bulkStatus']);
Route::post('twilio/bulk/{bulkId}/retry', [TwilioController::class, 'bulkRetry']);

// Statistics routes
Route::get('mailings/statistics', [MailingController::class, 'allStatistics']);