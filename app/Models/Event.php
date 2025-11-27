<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'template_id',
        'title',
        'description',
        'event_date',
        'location',
        'status'
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    // Relations
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function mailings()
    {
        return $this->hasMany(Mailing::class);
    }
}