<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Actualite extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    protected $table = 'actualites';

    protected $fillable = [
        'titre',
        'contenu', // Or 'details' if you mapped it that way
        'autorite_contractante',
        'gestion',
        'details', // Add if distinct from contenu
        'montant',
        'type_marche',
        'mode_passation',
        'document_titre',
        'document_path', // Ensure this is the correct name
        'document_contenu',
        'date_publication',
        'categorie',
        'auteur_id', // Or 'user_id'
        'auteur',    // If you kept this text field
        'status',    // Added status
    ];

    protected $casts = [
        'date_publication' => 'date',
        'gestion' => 'integer',
        'montant' => 'decimal:2',
    ];

    /**
     * Get the user who created this record.
     */
    public function auteur() // Or function user()
    {
        return $this->belongsTo(User::class, 'auteur_id'); // Adjust 'auteur_id' if needed
    }

    /**
     * Get the full URL for the document PDF.
     */
    public function getDocumentUrlAttribute(): ?string
    {
        if ($this->document_path) {
            // IMPORTANT: Ensure 'public' disk is linked (php artisan storage:link)
            // and configured correctly in config/filesystems.php
            if (Storage::disk('public')->exists($this->document_path)) {
                 return Storage::disk('public')->url($this->document_path);
            }
        }
        return null; // Return null if no path or file doesn't exist
    }

    /**
     * Scope a query to only include published items.
     */
    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }
}