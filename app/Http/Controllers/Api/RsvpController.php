<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rsvp\StoreRsvpRequest;
use App\Http\Requests\Rsvp\UpdateRsvpRequest;
use App\Models\Rsvp;

class RsvpController extends Controller
{
    public function index()
    {
        return response()->json(Rsvp::all());
    }

    public function store(StoreRsvpRequest $request)
    {
        $rsvp = Rsvp::create($request->validated());

        return response()->json($rsvp, 201);
    }

    public function show(Rsvp $rsvp)
    {
        return response()->json($rsvp->load('guest'));
    }

    public function update(UpdateRsvpRequest $request, Rsvp $rsvp)
    {
        $rsvp->update($request->validated());

        return response()->json($rsvp);
    }

    public function destroy(Rsvp $rsvp)
    {
        $rsvp->delete();

        return response()->json(['message' => 'RSVP deleted successfully']);
    }
}
