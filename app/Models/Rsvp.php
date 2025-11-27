<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'status',
        'plus_one_count',
        'answers'
    ];

    protected $casts = [
        'answers' => 'array'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}