<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BulkSend;
use App\Http\Requests\BulkSend\StoreBulkSendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulkSendController extends Controller
{
    /**
     * Créer un envoi en masse
     */
    public function store(StoreBulkSendRequest $request)
    {
        $validated = $request->validated();

        $bulkSend = BulkSend::create([
            'user_id' => Auth::id(),
            'event_id' => $validated['event_id'],
            'channel' => $validated['channel'],
            'subject' => $validated['subject'] ?? null,
            'body' => $validated['body'],
            'recipients' => $validated['recipients'],
            'total_count' => count($validated['recipients']),
            'sent_count' => 0,
            'failed_count' => 0,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Bulk send created successfully',
            'bulk_send' => $bulkSend,
        ], 201);
    }

    /**
     * Obtenir le statut d'un envoi en masse
     */
    public function status(BulkSend $bulkSend)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($bulkSend->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'id' => $bulkSend->id,
            'channel' => $bulkSend->channel,
            'status' => $bulkSend->status,
            'total_count' => $bulkSend->total_count,
            'sent_count' => $bulkSend->sent_count,
            'failed_count' => $bulkSend->failed_count,
            'progress' => $bulkSend->total_count > 0 
                ? round(($bulkSend->sent_count / $bulkSend->total_count) * 100, 2)
                : 0,
            'started_at' => $bulkSend->started_at,
            'completed_at' => $bulkSend->completed_at,
        ]);
    }

    /**
     * Lister les envois en masse
     */
    public function index(Request $request)
    {
        $query = BulkSend::where('user_id', Auth::id());

        if ($request->has('limit')) {
            $query->limit($request->input('limit'));
        }

        $bulkSends = $query->orderBy('created_at', 'desc')->get();

        return response()->json($bulkSends);
    }

    /**
     * Annuler un envoi en masse
     */
    public function cancel(BulkSend $bulkSend)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($bulkSend->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($bulkSend->status === 'completed') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot cancel a completed bulk send',
            ], 400);
        }

        $bulkSend->cancel();

        return response()->json([
            'message' => 'Bulk send cancelled successfully',
            'bulk_send' => $bulkSend,
        ]);
    }

    /**
     * Réessayer un envoi en masse
     */
    public function retry(BulkSend $bulkSend)
    {
        // Vérifier que l'utilisateur est propriétaire
        if ($bulkSend->user_id !== Auth::id()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }

        if ($bulkSend->status === 'pending') {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot retry a pending bulk send',
            ], 400);
        }

        $bulkSend->retry();

        return response()->json([
            'message' => 'Bulk send retry initiated',
            'bulk_send' => $bulkSend,
        ]);
    }
}
