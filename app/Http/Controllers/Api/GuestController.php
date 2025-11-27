<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\StoreGuestRequest;
use App\Http\Requests\Guest\UpdateGuestRequest;
use App\Http\Requests\Guest\ImportGuestRequest;
use App\Models\Guest;
use App\Models\Event;

class GuestController extends Controller
{
    public function index()
    {
        return response()->json(Guest::all());
    }

    public function store(StoreGuestRequest $request)
    {
        $guest = Guest::create($request->validated());

        return response()->json($guest, 201);
    }

    public function show(Guest $guest)
    {
        return response()->json($guest->load(['event', 'rsvps']));
    }

    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $guest->update($request->validated());

        return response()->json($guest);
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();

        return response()->json(['message' => 'Guest deleted successfully']);
    }

    public function import(ImportGuestRequest $request, Event $event)
    {
        $guests = [];
        foreach ($request->validated()['guests'] as $guestData) {
            $guests[] = Guest::create([
                'event_id' => $event->id,
                'name' => $guestData['name'],
                'email' => $guestData['email'],
                'phone' => $guestData['phone'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Guests imported successfully',
            'guests' => $guests,
        ], 201);
    }
}
