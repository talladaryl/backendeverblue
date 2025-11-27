<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'full_name',
        'email',
        'phone',
        'plus_one_allowed',
        'metadata',
    ];

    protected $casts = [
        'plus_one_allowed' => 'boolean',
        'metadata' => 'array',
    ];

    // Relations
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}