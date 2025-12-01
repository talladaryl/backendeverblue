<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::with(['user', 'events'])->get();
        return response()->json($organizations);
    }

    public function store(StoreOrganizationRequest $request)
    {
        $organization = Organization::create(array_merge(
            $request->validated(),
            ['user_id' => Auth::id()]
        ));

        return response()->json($organization, 201);
    }

    public function show(Organization $organization)
    {
        return response()->json($organization->load(['user', 'events']));
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($organization->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $organization->update($request->validated());

        return response()->json($organization);
    }

    public function destroy(Organization $organization)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($organization->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $organization->delete();

        return response()->json(['message' => 'Organization deleted successfully']);
    }

    /**
     * Obtenir les organisations de l'utilisateur courant
     */
    public function myOrganizations()
    {
        $organizations = Organization::where('user_id', Auth::id())
            ->with('events')
            ->get();

        return response()->json($organizations);
    }

    /**
     * Obtenir les événements d'une organisation
     */
    public function events(Organization $organization)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($organization->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $events = $organization->events()->get();

        return response()->json($events);
    }

    /**
     * Obtenir les statistiques d'une organisation
     */
    public function statistics(Organization $organization)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($organization->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        $stats = [
            'total_events' => $organization->events()->count(),
            'active_events' => $organization->events()->where('is_archived', false)->count(),
            'archived_events' => $organization->events()->where('is_archived', true)->count(),
            'events_by_status' => [
                'active' => $organization->events()->where('status', 'active')->count(),
                'draftdraft' => $organization->events()->where('status', 'draft')->count(),
                'archived' => $organization->events()->where('status', 'archive')->count(),
            ],
        ];

        return response()->json($stats);
    }
}