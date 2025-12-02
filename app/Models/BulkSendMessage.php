<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkSendMessage extends Model
{
    protected $fillable = [
        'bulk_send_id',
        'recipient',
        'name',
        'status',
        'error',
        'channel',
        'message_id',
    ];

    public function bulkSend()
    {
        return $this->belongsTo(BulkSend::class);
    }
}