<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Importer HasMany
use Illuminate\Database\Eloquent\Relations\BelongsTo; // <-- Importer BelongsTo
use Carbon\Carbon; // <-- Importer Carbon pour les accesseurs de date

class Event extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',        // Qui a créé l'événement (clé étrangère vers users.id)
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'type',
        'max_participants',
        'image',
        'is_published',
        'first_name',  // Nouveau champ : Prénom
        'last_name',   // Nouveau champ : Nom
        'phone_number', // Nouveau champ : Numéro de téléphone
        'email'       // Nouveau champ : Email
    ];

    /**
     * Les attributs qui doivent être castés.
     * Ajout de is_published et max_participants pour une meilleure gestion.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'image',  
        'is_published' => 'boolean',
        'max_participants' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur (Admin) qui a créé l'événement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Assurez-vous que App\Models\User existe
    }

    /**
     * Récupère toutes les inscriptions (Registration) associées à cet événement.
     * === C'EST LA MÉTHODE QUI MANQUAIT ===
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrations(): HasMany
    {
        // Laravel utilise les conventions:
        // Clé étrangère sur la table 'registrations' : event_id
        // Clé locale sur la table 'events' : id
        return $this->hasMany(Registration::class); // Assurez-vous que App\Models\Registration existe
    }


    // --- ACCESSEURS OPTIONNELS (pour faciliter l'utilisation dans les vues) ---

    /**
     * Accesseur pour obtenir le chemin complet de l'URL de l'image ou une image par défaut.
     * Exemple d'utilisation: $event->image_url
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {
        // Vérifie si l'image existe et si le fichier est présent dans le dossier public
        if ($this->image && file_exists(public_path('images/events/' . $this->image))) {
            // Retourne l'URL publique de l'image
            return asset('images/events/' . $this->image);
        }
        // Retourne l'URL d'une image placeholder si aucune image n'est trouvée
        // Assurez-vous que 'images/event-placeholder.jpg' existe dans votre dossier public/images
        return asset('images/event-placeholder.jpg');
    }

    /**
     * Vérifie si l'événement est terminé.
     * Exemple d'utilisation: $event->is_finished
     */
    public function getIsFinishedAttribute(): bool
    {
        // Compare la date de fin avec la date/heure actuelle
        return $this->end_date < Carbon::now();
    }

    /**
     * Vérifie si l'événement est en cours.
     * Exemple d'utilisation: $event->is_ongoing
     */
    public function getIsOngoingAttribute(): bool
    {
        $now = Carbon::now();
        // Vérifie si la date/heure actuelle est entre la date de début et la date de fin
        return $now->betweenIncluded($this->start_date, $this->end_date); // Utiliser betweenIncluded
    }

    /**
     * Vérifie si l'événement est à venir.
     * Exemple d'utilisation: $event->is_upcoming
     */
    public function getIsUpcomingAttribute(): bool
    {
        // Vérifie si la date de début est postérieure à la date/heure actuelle
        return $this->start_date > Carbon::now();
    }
}