<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessagePostAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'path',
        'original_name',
        'mime_type',
        'size'
    ];

    /**
     * Le post auquel appartient cette pièce jointe
     */
    public function post()
    {
        return $this->belongsTo(MessagePost::class, 'post_id');
    }

    /**
     * Récupérer l'URL de la pièce jointe
     */
    public function getUrlAttribute()
    {
        return url('storage/' . $this->path);
    }

    /**
     * Vérifier si c'est une image
     */
    public function isImage()
    {
        return strpos($this->mime_type, 'image/') === 0;
    }

    /**
     * Vérifier si c'est une vidéo
     */
    public function isVideo()
    {
        return strpos($this->mime_type, 'video/') === 0;
    }

    /**
     * Vérifier si c'est un audio
     */
    public function isAudio()
    {
        return strpos($this->mime_type, 'audio/') === 0;
    }

    /**
     * Récupérer la taille du fichier formatée (KB, MB, etc)
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;
        
        if ($bytes < 1024) {
            return $bytes . ' octets';
        } elseif ($bytes < 1048576) {
            return round($bytes / 1024, 2) . ' Ko';
        } elseif ($bytes < 1073741824) {
            return round($bytes / 1048576, 2) . ' Mo';
        } else {
            return round($bytes / 1073741824, 2) . ' Go';
        }
    }
}
