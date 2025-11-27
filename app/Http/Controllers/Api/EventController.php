<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Http\Requests\Event\ChangeStatusRequest;
use App\Http\Requests\Event\ArchiveEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Filtrer par statut
        if ($request->has('status')) {
            $query->byStatus($request->input('status'));
        }

        // Filtrer par archivage
        if ($request->has('archived')) {
            $archived = $request->input('archived') === 'true' || $request->input('archived') === '1';
            $archived ? $query->archived() : $query->active();
        } else {
            // Par défaut, afficher seulement les événements actifs
            $query->active();
        }

        // Trier par date
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            if ($sort === 'upcoming') {
                $query->upcoming();
            } elseif ($sort === 'past') {
                $query->past();
            }
        }

        return response()->json($query->get());
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create(array_merge(
            $request->validated(),
            [
                'status' => 'planning',
                'is_archived' => false,
            ]
        ));

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event->load(['guests', 'mailings', 'template', 'organization']));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }

    /**
     * Changer le statut d'un événement
     */
    public function changeStatus(ChangeStatusRequest $request, Event $event)
    {
        $event->changeStatus($request->input('status'));

        return response()->json([
            'message' => 'Event status changed successfully',
            'event' => $event,
        ]);
    }

    /**
     * Archiver un événement
     */
    public function archive(ArchiveEventRequest $request, Event $event)
    {
        if ($event->isArchived()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event is already archived',
            ], 400);
        }

        $event->archive();

        return response()->json([
            'message' => 'Event archived successfully',
            'event' => $event,
        ]);
    }

    /**
     * Désarchiver un événement
     */
    public function unarchive(Event $event)
    {
        if (!$event->isArchived()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Event is not archived',
            ], 400);
        }

        $event->unarchive();

        return response()->json([
            'message' => 'Event unarchived successfully',
            'event' => $event,
        ]);
    }

    /**
     * Obtenir les événements archivés
     */
    public function archived()
    {
        $events = Event::archived()->get();

        return response()->json($events);
    }

    /**
     * Obtenir les événements actifs
     */
    public function active()
    {
        $events = Event::active()->get();

        return response()->json($events);
    }

    /**
     * Obtenir les événements à venir
     */
    public function upcoming()
    {
        $events = Event::upcoming()->get();

        return response()->json($events);
    }

    /**
     * Obtenir les événements passés
     */
    public function past()
    {
        $events = Event::past()->get();

        return response()->json($events);
    }

    /**
     * Obtenir les statistiques des événements
     */
    public function statistics()
    {
        $stats = [
            'total' => Event::count(),
            'active' => Event::active()->count(),
            'archived' => Event::archived()->count(),
            'by_status' => [
                'planning' => Event::byStatus('planning')->count(),
                'confirmed' => Event::byStatus('confirmed')->count(),
                'ongoing' => Event::byStatus('ongoing')->count(),
                'completed' => Event::byStatus('completed')->count(),
                'cancelled' => Event::byStatus('cancelled')->count(),
            ],
            'upcoming' => Event::upcoming()->count(),
            'past' => Event::past()->count(),
        ];

        return response()->json($stats);
    }
}
