<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;

class TwilioService
{
    protected Client $client;

    protected string $fromPhone;

    protected string $fromWhatsApp;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.account_sid'),
            config('services.twilio.auth_token')
        );

        $this->fromPhone = config('services.twilio.phone_number');
        $this->fromWhatsApp = config('services.twilio.whatsapp_number');
    }

    /**
     * Send SMS
     */
    public function sendSMS(string $toPhone, string $message): array
    {
        try {
            $msg = $this->client->messages->create(
                $toPhone,
                [
                    'from' => $this->fromPhone,
                    'body' => $message,
                ]
            );

            Log::info('SMS sent successfully', [
                'sid' => $msg->sid,
                'to' => $toPhone,
            ]);

            return [
                'status' => 'success',
                'message_id' => $msg->sid,
                'status_code' => $msg->status,
                'type' => 'sms',
            ];
        } catch (Exception $e) {
            Log::error('Failed to send SMS', [
                'error' => $e->getMessage(),
                'to' => $toPhone,
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'sms',
            ];
        }
    }

    /**
     * Send MMS
     */
    public function sendMMS(string $toPhone, string $message, array $mediaUrls = []): array
    {
        try {
            $params = [
                'from' => $this->fromPhone,
                'body' => $message,
            ];

            if (!empty($mediaUrls)) {
                $params['mediaUrl'] = $mediaUrls;
            }

            $msg = $this->client->messages->create($toPhone, $params);

            Log::info('MMS sent successfully', [
                'sid' => $msg->sid,
                'to' => $toPhone,
                'media_count' => count($mediaUrls),
            ]);

            return [
                'status' => 'success',
                'message_id' => $msg->sid,
                'status_code' => $msg->status,
                'type' => 'mms',
            ];
        } catch (Exception $e) {
            Log::error('Failed to send MMS', [
                'error' => $e->getMessage(),
                'to' => $toPhone,
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'mms',
            ];
        }
    }

    /**
     * Send WhatsApp message
     */
    public function sendWhatsApp(string $toWhatsApp, string $message): array
    {
        try {
            if (!str_starts_with($toWhatsApp, 'whatsapp:')) {
                $toWhatsApp = 'whatsapp:' . $toWhatsApp;
            }

            $msg = $this->client->messages->create(
                $toWhatsApp,
                [
                    'from' => $this->fromWhatsApp,
                    'body' => $message,
                ]
            );

            Log::info('WhatsApp message sent successfully', [
                'sid' => $msg->sid,
                'to' => $toWhatsApp,
            ]);

            return [
                'status' => 'success',
                'message_id' => $msg->sid,
                'status_code' => $msg->status,
                'type' => 'whatsapp',
            ];
        } catch (Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'error' => $e->getMessage(),
                'to' => $toWhatsApp,
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'whatsapp',
            ];
        }
    }

    /**
     * Send Email via Twilio SendGrid
     */
    public function sendEmail(string $toEmail, string $subject, string $body, string $htmlBody = null): array
    {
        try {
            $email = $this->client->messages->create(
                'mailto:' . $toEmail,
                [
                    'from' => 'mailto:' . config('mail.from.address'),
                    'subject' => $subject,
                    'body' => $body,
                ]
            );

            Log::info('Email sent successfully', [
                'sid' => $email->sid,
                'to' => $toEmail,
            ]);

            return [
                'status' => 'success',
                'message_id' => $email->sid,
                'type' => 'email',
            ];
        } catch (Exception $e) {
            Log::error('Failed to send email', [
                'error' => $e->getMessage(),
                'to' => $toEmail,
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'type' => 'email',
            ];
        }
    }

    /**
     * Send bulk messages
     */
    public function sendBulk(array $recipients, string $message, string $type = 'sms'): array
    {
        $results = [];
        $successful = 0;
        $failed = 0;

        foreach ($recipients as $recipient) {
            $result = match ($type) {
                'sms' => $this->sendSMS($recipient, $message),
                'whatsapp' => $this->sendWhatsApp($recipient, $message),
                'mms' => $this->sendMMS($recipient, $message),
                default => ['status' => 'error', 'message' => 'Invalid type'],
            };

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
            'status' => $failed === 0 ? 'success' : 'partial',
            'total' => count($recipients),
            'successful' => $successful,
            'failed' => $failed,
            'results' => $results,
        ];
    }

    /**
     * Get message status
     */
    public function getMessageStatus(string $messageSid): array
    {
        try {
            $message = $this->client->messages($messageSid)->fetch();

            return [
                'status' => 'success',
                'message_id' => $message->sid,
                'status_code' => $message->status,
                'date_sent' => $message->dateSent,
                'date_updated' => $message->dateUpdated,
            ];
        } catch (Exception $e) {
            Log::error('Failed to get message status', [
                'error' => $e->getMessage(),
                'sid' => $messageSid,
            ]);

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
