<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MessageShare extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'share_token'
    ];

    /**
     * Le hook boot pour définir automatiquement un token de partage unique
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($share) {
            if (!$share->share_token) {
                $share->share_token = Str::random(32);
            }
        });
    }

    /**
     * Le post qui est partagé
     */
    public function post()
    {
        return $this->belongsTo(MessagePost::class, 'post_id');
    }

    /**
     * L'utilisateur qui a partagé le post
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Récupérer l'URL de partage
     */
    public function getShareUrlAttribute()
    {
        return route('messagerie-sociale.shared-post', $this->share_token);
    }
}
