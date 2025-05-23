<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Garder si email verification est activée
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Si vous utilisez Sanctum

// Importer les modèles liés
use App\Models\Etudiant;
use App\Models\Entreprise;
use App\Models\Conversation;
use App\Models\Message;

// Remplacer implements MustVerifyEmail si vous ne l'utilisez pas
class User extends Authenticatable // implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Les attributs qui sont assignables en masse.
     * Ajoutez 'role' ici.
     */
    protected $fillable = [
        'name', // Sera utilisé comme nom complet pour l'instant
        'email',
        'password',
        'role', // Important
    ];

    /**
     * Les attributs qui devraient être cachés pour la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui devraient être castés.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'password' => 'hashed', // Utilise le nouveau cast de Laravel 9+
    ];

    // Constantes pour les rôles (meilleure pratique)
    public const ROLE_ADMIN = 'admin';
    public const ROLE_ETUDIANT = 'etudiant';
    public const ROLE_RECRUTEUR = 'recruteur';

    // ----- RELATIONS -----

    // Un utilisateur peut avoir un profil étudiant
    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    // Un utilisateur peut avoir un profil entreprise (recruteur)
    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    // ----- RELATIONS DE MESSAGERIE -----

    /**
     * Les conversations auxquelles l'utilisateur participe
     */
    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read')
            ->withTimestamps()
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Les messages envoyés par l'utilisateur
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // ----- HELPERS DE RÔLE -----

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEtudiant(): bool
    {
        return $this->role === self::ROLE_ETUDIANT;
    }

    public function isRecruteur(): bool
    {
        return $this->role === self::ROLE_RECRUTEUR;
    }

    // Helper pour obtenir le profil spécifique
    public function profile()
    {
        if ($this->isEtudiant()) {
            return $this->etudiant;
        } elseif ($this->isRecruteur()) {
            return $this->entreprise;
        }
        return null; // Pour admin ou autre
    }

    /**
     * Récupère les conversations non lues pour l'utilisateur
     */
    public function unreadConversations()
    {
        return $this->conversations()
            ->whereExists(function ($query) {
                $query->from('messages')
                    ->whereColumn('messages.conversation_id', 'conversations.id')
                    ->where('messages.is_read', false)
                    ->where('messages.user_id', '!=', $this->id);
            });
    }

    /**
     * Récupère le nombre total de messages non lus
     */
    public function unreadMessagesCount()
    {
        $count = 0;
        foreach ($this->conversations as $conversation) {
            $count += $conversation->unreadMessagesCount($this->id);
        }
        return $count;
    }
}
