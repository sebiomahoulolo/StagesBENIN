<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'body',
        'type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * L'utilisateur qui a envoyé le message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La conversation à laquelle appartient ce message
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Les pièces jointes du message
     */
    public function attachments()
    {
        return $this->hasMany(MessageAttachment::class);
    }

    /**
     * Vérifie si le message est de l'utilisateur donné
     */
    public function isFromUser($userId)
    {
        return $this->user_id === $userId;
    }

    /**
     * Vérifie si le message est une image
     */
    public function isImage()
    {
        return $this->type === 'image';
    }

    /**
     * Vérifie si le message est une vidéo
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Vérifie si le message est un audio
     */
    public function isAudio()
    {
        return $this->type === 'audio';
    }

    /**
     * Vérifie si le message est un fichier
     */
    public function isFile()
    {
        return $this->type === 'file';
    }
} 