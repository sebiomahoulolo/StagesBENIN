<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    /**
     * Le message auquel appartient cette pièce jointe
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Récupère l'URL de la pièce jointe
     */
    public function getUrl()
    {
        return url('storage/' . $this->file_path);
    }

    /**
     * Vérifie si c'est une image
     */
    public function isImage()
    {
        return strpos($this->file_type, 'image/') === 0;
    }

    /**
     * Vérifie si c'est une vidéo
     */
    public function isVideo()
    {
        return strpos($this->file_type, 'video/') === 0;
    }

    /**
     * Vérifie si c'est un audio
     */
    public function isAudio()
    {
        return strpos($this->file_type, 'audio/') === 0;
    }

    /**
     * Récupère la taille du fichier formatée (KB, MB, etc)
     */
    public function getFormattedSize()
    {
        $bytes = $this->file_size;
        
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