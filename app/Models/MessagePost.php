<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessagePost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'content',
        'is_published',
        'edited_at'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'edited_at' => 'datetime'
    ];

    /**
     * L'utilisateur qui a créé le post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Les commentaires associés au post
     */
    public function comments()
    {
        return $this->hasMany(MessageComment::class, 'post_id');
    }

    /**
     * Les partages du post
     */
    public function shares()
    {
        return $this->hasMany(MessageShare::class, 'post_id');
    }

    /**
     * Les pièces jointes du post
     */
    public function attachments()
    {
        return $this->hasMany(MessagePostAttachment::class, 'post_id');
    }

    /**
     * Vérifier si l'utilisateur peut modifier/supprimer le post
     */
    public function canEdit($userId)
    {
        return $this->user_id === $userId;
    }

    /**
     * Récupérer le nombre de commentaires
     */
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }

    /**
     * Récupérer le nombre de partages
     */
    public function getSharesCountAttribute()
    {
        return $this->shares()->count();
    }
}
