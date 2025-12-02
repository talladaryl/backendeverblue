<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Services\TwilioService;

class BulkSendService
{
    public function __construct(
        private TwilioService $twilioService
    ) {}

    /**
     * Envoyer en masse selon le canal choisi
     */
    public function sendBulk(Event $event, string $channel, ?string $subject = null): array
    {
        $template = $event->template;
        if (!$template) {
            return ['status' => 'error', 'message' => 'Aucun template'];
        }

        // Filtrer les invités pour les canaux nécessitant un téléphone
        $guests = $event->guests()->get()->filter(fn($g) => $channel !== 'email' ? $g->phone : true);

        if ($guests->isEmpty()) {
            return ['status' => 'error', 'message' => 'Aucun invité disponible pour ce canal'];
        }

        $successful = 0;
        $failed = 0;
        $results = [];

        foreach ($guests as $guest) {
            $result = match ($channel) {
                'email' => $this->sendEmail($guest, $template, $subject ?? $event->title),
                'sms' => $this->sendSMS($guest, $template),
                'whatsapp' => $this->sendWhatsApp($guest, $template),
                'mms' => $this->sendMMS($guest, $template),
                default => ['status' => 'error', 'message' => 'Canal invalide'],
            };

            $results[] = ['guest_id' => $guest->id, 'result' => $result];

            if ($result['status'] === 'success') $successful++;
            else $failed++;
        }

        return [
            'status' => $successful === 0 ? 'error' : ($failed > 0 ? 'partial' : 'success'),
            'total' => count($guests),
            'successful' => $successful,
            'failed' => $failed,
            'results' => $results,
        ];
    }

    private function sendEmail($guest, $template, string $subject): array
    {
        try {
            Mail::raw($template->content ?? 'Invitation', function (Message $message) use ($guest, $subject) {
                $message->to($guest->email)->subject($subject);
            });
            return ['status' => 'success', 'type' => 'email'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'type' => 'email', 'message' => $e->getMessage()];
        }
    }

    private function sendSMS($guest, $template): array
    {
        if (!$guest->phone) return ['status' => 'error', 'message' => 'Pas de téléphone'];
        $message = substr($template->content ?? 'Invitation', 0, 160);
        return $this->twilioService->sendSMS($guest->phone, $message);
    }

    private function sendWhatsApp($guest, $template): array
    {
        if (!$guest->phone) return ['status' => 'error', 'message' => 'Pas de téléphone'];
        return $this->twilioService->sendWhatsApp($guest->phone, $template->content ?? 'Invitation');
    }

    private function sendMMS($guest, $template): array
    {
        if (!$guest->phone) return ['status' => 'error', 'message' => 'Pas de téléphone'];
        $message = substr($template->content ?? 'Invitation', 0, 160);
        return $this->twilioService->sendMMS($guest->phone, $message);
    }
}