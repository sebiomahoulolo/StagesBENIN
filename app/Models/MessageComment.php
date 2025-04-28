<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'edited_at'
    ];

    protected $casts = [
        'edited_at' => 'datetime'
    ];

    /**
     * Le post auquel appartient ce commentaire
     */
    public function post()
    {
        return $this->belongsTo(MessagePost::class, 'post_id');
    }

    /**
     * L'utilisateur qui a créé le commentaire
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le commentaire parent (si c'est une réponse)
     */
    public function parent()
    {
        return $this->belongsTo(MessageComment::class, 'parent_id');
    }

    /**
     * Obtenir les réponses à ce commentaire
     */
    public function replies()
    {
        return $this->hasMany(MessageComment::class, 'parent_id');
    }

    /**
     * Vérifier si ce commentaire est une réponse
     */
    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    /**
     * Vérifier si l'utilisateur peut modifier/supprimer le commentaire
     */
    public function canEdit($userId)
    {
        return $this->user_id === $userId;
    }
}
