<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mailing\BulkSendRequest;
use App\Models\Event;
use App\Services\BulkSendService;

class BulkSendController extends Controller
{
    public function __construct(
        private BulkSendService $bulkSendService
    ) {}

    /**
     * Envoyer en masse via un événement
     * Récupère le template et les guests de l'événement
     */
    public function send(BulkSendRequest $request)
    {
        try {
            $event = Event::findOrFail($request->input('event_id'));
            $channel = $request->input('channel');
            $subject = $request->input('subject');

            $result = $this->bulkSendService->sendBulk($event, $channel, $subject);

            $statusCode = $result['status'] === 'error' ? 400 : 201;
            return response()->json($result, $statusCode);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Prévisualiser le template d'un événement
     */
    public function preview(Event $event)
    {
        $template = $event->template;
        if (!$template) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aucun template pour cet événement',
            ], 404);
        }

        return response()->json([
            'event_id' => $event->id,
            'event_title' => $event->title,
            'template_id' => $template->id,
            'template_name' => $template->name,
            'template_content' => $template->content,
            'guests_count' => $event->guests()->count(),
        ]);
    }

    /**
     * Obtenir les informations d'envoi pour un événement
     */
    public function info(Event $event)
    {
        $template = $event->template;
        $guests = $event->guests()->get();

        return response()->json([
            'event_id' => $event->id,
            'event_title' => $event->title,
            'template' => $template ? [
                'id' => $template->id,
                'name' => $template->name,
            ] : null,
            'guests_count' => $guests->count(),
            'guests' => $guests->map(fn($g) => [
                'id' => $g->id,
                'name' => $g->name,
                'email' => $g->email,
                'phone' => $g->phone,
            ]),
        ]);
    }
}
