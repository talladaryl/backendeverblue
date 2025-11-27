<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'subject',
        'body',
        'channel',
        'type',
        'recipient_type',
        'recipients',
        'media_urls',
        'status',
        'scheduled_at',
        'sent_at',
        'sent_count',
        'failed_count',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'recipients' => 'array',
        'media_urls' => 'array',
        'metadata' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}