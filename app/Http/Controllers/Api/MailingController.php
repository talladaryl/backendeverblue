<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mailing\StoreMailingRequest;
use App\Http\Requests\Mailing\UpdateMailingRequest;
use App\Models\Mailing;
use App\Models\Event;
use App\Models\Guest;
use App\Services\TwilioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class MailingController extends Controller
{
    public function __construct(
        private TwilioService $twilioService
    ) {}

    public function index()
    {
        return response()->json(Mailing::all());
    }

    public function store(StoreMailingRequest $request)
    {
        $validated = $request->validated();

        $mailing = Mailing::create([
            'event_id' => $validated['event_id'],
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'channel' => $validated['channel'],
            'type' => $validated['type'] ?? 'single',
            'recipient_type' => $validated['recipient_type'] ?? 'custom',
            'recipients' => $validated['recipients'] ?? [],
            'media_urls' => $validated['media_urls'] ?? [],
            'status' => $validated['status'] ?? 'draft',
            'scheduled_at' => $validated['scheduled_at'] ?? null,
        ]);

        return response()->json($mailing, 201);
    }

    public function show(Mailing $mailing)
    {
        return response()->json($mailing->load('event'));
    }

    public function update(UpdateMailingRequest $request, Mailing $mailing)
    {
        $mailing->update($request->validated());

        return response()->json($mailing);
    }

    public function destroy(Mailing $mailing)
    {
        $mailing->delete();

        return response()->json(['message' => 'Mailing deleted successfully']);
    }

    /**
     * Send mailing immediately
     */
    public function send(Request $request, Mailing $mailing)
    {
        try {
            $recipients = $this->getRecipients($mailing);

            if (empty($recipients)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No recipients found',
                ], 400);
            }

            $result = $this->sendMessages($mailing, $recipients);

            $mailing->update([
                'status' => $result['failed'] === 0 ? 'sent' : 'failed',
                'sent_at' => now(),
                'sent_count' => $result['successful'],
                'failed_count' => $result['failed'],
                'metadata' => [
                    'results' => $result['results'],
                ],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Mailing sent successfully',
                'data' => [
                    'total' => $result['total'],
                    'successful' => $result['successful'],
                    'failed' => $result['failed'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Send test message
     */
    public function sendTest(Request $request, Mailing $mailing)
    {
        $request->validate([
            'recipient' => 'required|string',
        ]);

        try {
            $result = $this->sendMessage(
                $mailing->channel,
                $request->input('recipient'),
                $mailing->body,
                $mailing->subject,
                $mailing->media_urls
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Test message sent successfully',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get recipients based on mailing configuration
     */
    private function getRecipients(Mailing $mailing): array
    {
        if ($mailing->recipient_type === 'custom' && !empty($mailing->recipients)) {
            return $mailing->recipients;
        }

        if ($mailing->recipient_type === 'guest') {
            $guests = Guest::where('event_id', $mailing->event_id)->get();

            return match ($mailing->channel) {
                'email' => $guests->pluck('email')->toArray(),
                'sms', 'mms' => $guests->pluck('phone')->filter()->toArray(),
                'whatsapp' => $guests->pluck('phone')->filter()->toArray(),
                default => [],
            };
        }

        return [];
    }

    /**
     * Send messages to all recipients
     */
    private function sendMessages(Mailing $mailing, array $recipients): array
    {
        $results = [];
        $successful = 0;
        $failed = 0;

        foreach ($recipients as $recipient) {
            $result = $this->sendMessage(
                $mailing->channel,
                $recipient,
                $mailing->body,
                $mailing->subject,
                $mailing->media_urls
            );

            $results[] = [
                'recipient' => $recipient,
                'result' => $result,
            ];

            if ($result['status'] === 'success') {
                $successful++;
            } else {
                $failed++;
            }
        }

        return [
            'total' => count($recipients),
            'successful' => $successful,
            'failed' => $failed,
            'results' => $results,
        ];
    }

    /**
     * Send a single message
     */
    private function sendMessage(
        string $channel,
        string $recipient,
        string $body,
        ?string $subject = null,
        array $mediaUrls = []
    ): array {
        return match ($channel) {
            'email' => $this->sendEmailMessage($recipient, $subject, $body),
            'sms' => $this->twilioService->sendSMS($recipient, $body),
            'mms' => $this->twilioService->sendMMS($recipient, $body, $mediaUrls),
            'whatsapp' => $this->twilioService->sendWhatsApp($recipient, $body),
            default => ['status' => 'error', 'message' => 'Invalid channel'],
        };
    }

    /**
     * Send email message
     */
    private function sendEmailMessage(string $email, ?string $subject, string $body): array
    {
        try {
            Mail::raw($body, function (Message $message) use ($email, $subject) {
                $message->to($email)
                    ->subject($subject ?? 'Message from Event');
            });

            return [
                'status' => 'success',
                'type' => 'email',
                'message' => 'Email sent successfully',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'type' => 'email',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get mailing statistics
     */
    public function statistics(Event $event)
    {
        $mailings = Mailing::where('event_id', $event->id)->get();

        $stats = [
            'total_mailings' => $mailings->count(),
            'sent' => $mailings->where('status', 'sent')->count(),
            'failed' => $mailings->where('status', 'failed')->count(),
            'draft' => $mailings->where('status', 'draft')->count(),
            'scheduled' => $mailings->where('status', 'scheduled')->count(),
            'by_channel' => [
                'email' => $mailings->where('channel', 'email')->count(),
                'sms' => $mailings->where('channel', 'sms')->count(),
                'whatsapp' => $mailings->where('channel', 'whatsapp')->count(),
                'mms' => $mailings->where('channel', 'mms')->count(),
            ],
            'total_sent' => $mailings->sum('sent_count'),
            'total_failed' => $mailings->sum('failed_count'),
        ];

        return response()->json($stats);
    }
}
