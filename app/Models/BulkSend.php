<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkSend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'channel',
        'subject',
        'body',
        'recipients',
        'total_count',
        'sent_count',
        'failed_count',
        'status',
        'started_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'recipients' => 'array',
        'metadata' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeByChannel($query, $channel)
    {
        return $query->where('channel', $channel);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Methods
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
        return $this;
    }

    public function retry()
    {
        $this->update([
            'status' => 'pending',
            'sent_count' => 0,
            'failed_count' => 0,
        ]);
        return $this;
    }
}
