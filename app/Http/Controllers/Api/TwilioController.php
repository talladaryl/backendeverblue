<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MessageHistory;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwilioController extends Controller
{
    public function __construct(
        private TwilioService $twilioService
    ) {}

    /**
     * Envoyer un message via Twilio
     */
    public function send(Request $request, $channel)
    {
        $validated = $request->validate([
            'recipient' => 'required|string',
            'message' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $result = match ($channel) {
            'sms' => $this->twilioService->sendSMS($validated['recipient'], $validated['message']),
            'whatsapp' => $this->twilioService->sendWhatsApp($validated['recipient'], $validated['message']),
            default => ['status' => 'error', 'message' => 'Invalid channel'],
        };

        if ($result['status'] === 'success') {
            MessageHistory::create([
                'user_id' => Auth::id(),
                'event_id' => $validated['event_id'] ?? null,
                'channel' => $channel,
                'recipient' => $validated['recipient'],
                'message_sid' => $result['message_id'] ?? null,
                'status' => 'success',
                'message_body' => $validated['message'],
                'sent_at' => now(),
            ]);
        }

        return response()->json($result);
    }

    /**
     * Envoyer des messages en masse
     */
    public function sendBulk(Request $request)
    {
        $validated = $request->validate([
            'channel' => 'required|string|in:sms,whatsapp',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'required|string',
            'message' => 'required|string',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $successful = 0;
        $failed = 0;
        $results = [];

        foreach ($validated['recipients'] as $recipient) {
            $result = match ($validated['channel']) {
                'sms' => $this->twilioService->sendSMS($recipient, $validated['message']),
                'whatsapp' => $this->twilioService->sendWhatsApp($recipient, $validated['message']),
                default => ['status' => 'error', 'message' => 'Invalid channel'],
            };

            $status = $result['status'] === 'success' ? 'success' : 'failed';

            MessageHistory::create([
                'user_id' => Auth::id(),
                'event_id' => $validated['event_id'] ?? null,
                'channel' => $validated['channel'],
                'recipient' => $recipient,
                'message_sid' => $result['message_id'] ?? null,
                'status' => $status,
                'message_body' => $validated['message'],
                'error_message' => $result['message'] ?? null,
                'sent_at' => now(),
            ]);

            $results[] = [
                'recipient' => $recipient,
                'status' => $status,
            ];

            if ($status === 'success') {
                $successful++;
            } else {
                $failed++;
            }
        }

        return response()->json([
            'total' => count($validated['recipients']),
            'successful' => $successful,
            'failed' => $failed,
            'results' => $results,
        ]);
    }

    /**
     * Obtenir l'historique des messages
     */
    public function history(Request $request)
    {
        $query = MessageHistory::where('user_id', Auth::id());

        if ($request->has('channel')) {
            $query->byChannel($request->input('channel'));
        }

        $messages = $query->orderBy('sent_at', 'desc')->get();

        return response()->json($messages);
    }

    /**
     * Obtenir le statut d'un message
     */
    public function messageStatus($messageSid)
    {
        $message = MessageHistory::where('message_sid', $messageSid)
            ->where('user_id', Auth::id())
            ->first();

        if (!$message) {
            return response()->json([
                'status' => 'error',
                'message' => 'Message not found',
            ], 404);
        }

        return response()->json([
            'message_sid' => $message->message_sid,
            'status' => $message->status,
            'channel' => $message->channel,
            'recipient' => $message->recipient,
            'sent_at' => $message->sent_at,
        ]);
    }

    /**
     * Obtenir le statut d'un envoi en masse
     */
    public function bulkStatus($bulkId)
    {
        $messages = MessageHistory::where('user_id', Auth::id())
            ->where('metadata->bulk_id', $bulkId)
            ->get();

        if ($messages->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bulk send not found',
            ], 404);
        }

        $successful = $messages->where('status', 'success')->count();
        $failed = $messages->where('status', 'failed')->count();

        return response()->json([
            'bulk_id' => $bulkId,
            'total' => $messages->count(),
            'successful' => $successful,
            'failed' => $failed,
            'progress' => round(($successful / $messages->count()) * 100, 2),
        ]);
    }

    /**
     * Réessayer un envoi en masse
     */
    public function bulkRetry($bulkId)
    {
        $messages = MessageHistory::where('user_id', Auth::id())
            ->where('metadata->bulk_id', $bulkId)
            ->where('status', 'failed')
            ->get();

        if ($messages->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No failed messages to retry',
            ], 400);
        }

        $successful = 0;
        $failed = 0;

        foreach ($messages as $message) {
            $result = match ($message->channel) {
                'sms' => $this->twilioService->sendSMS($message->recipient, $message->message_body),
                'whatsapp' => $this->twilioService->sendWhatsApp($message->recipient, $message->message_body),
                default => ['status' => 'error'],
            };

            if ($result['status'] === 'success') {
                $message->update([
                    'status' => 'success',
                    'message_sid' => $result['message_id'] ?? null,
                ]);
                $successful++;
            } else {
                $failed++;
            }
        }

        return response()->json([
            'retried' => $messages->count(),
            'successful' => $successful,
            'failed' => $failed,
        ]);
    }
}
