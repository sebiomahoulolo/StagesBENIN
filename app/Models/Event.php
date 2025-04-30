<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'type',
        'max_participants',
        'image',
        'is_published'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Relation avec l'utilisateur qui a créé l'événement
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
