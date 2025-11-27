<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'prompt',
        'negative_prompt',
        'image_url',
        'thumbnail_url',
        'style',
        'size',
        'quality',
        'task_id',
        'status',
        'ai_model',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class)->nullable();
    }
}
