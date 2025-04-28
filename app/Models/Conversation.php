<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_group',
    ];

    protected $casts = [
        'is_group' => 'boolean',
    ];

    /**
     * Les participants de la conversation
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('last_read')
            ->withTimestamps();
    }

    /**
     * Les messages de la conversation
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Le dernier message de la conversation
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->orderBy('created_at', 'desc');
    }

    /**
     * Vérifie si l'utilisateur est un participant de cette conversation
     */
    public function isParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    /**
     * Obtenir le nom de la conversation pour un utilisateur donné
     * Si c'est une conversation de groupe, renvoie le nom du groupe
     * Sinon, renvoie le nom de l'autre participant
     */
    public function getNameForUser($userId)
    {
        if ($this->is_group) {
            return $this->name;
        }

        $otherParticipant = $this->participants()
            ->where('user_id', '!=', $userId)
            ->first();

        return $otherParticipant ? $otherParticipant->name : 'Conversation privée';
    }

    /**
     * Récupérer le nombre de messages non lus pour un utilisateur
     */
    public function unreadMessagesCount($userId)
    {
        $lastRead = $this->participants()
            ->where('user_id', $userId)
            ->first()
            ->pivot
            ->last_read;

        if (!$lastRead) {
            return $this->messages()->count();
        }

        return $this->messages()
            ->where('created_at', '>', $lastRead)
            ->where('user_id', '!=', $userId)
            ->count();
    }
} 