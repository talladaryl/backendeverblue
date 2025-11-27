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
        'status',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'archived_at' => 'datetime',
        'is_archived' => 'boolean',
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

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', now())
            ->where('is_archived', false)
            ->orderBy('event_date', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now())
            ->where('is_archived', false)
            ->orderBy('event_date', 'desc');
    }

    // Methods
    public function archive()
    {
        $this->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);
        return $this;
    }

    public function unarchive()
    {
        $this->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);
        return $this;
    }

    public function changeStatus($newStatus)
    {
        $this->update(['status' => $newStatus]);
        return $this;
    }

    public function isArchived()
    {
        return $this->is_archived;
    }

    public function isActive()
    {
        return !$this->is_archived;
    }
}