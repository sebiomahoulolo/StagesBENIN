<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\UploadedFile;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfFile;

    public function __construct($data, UploadedFile $pdfFile)
    {
        $this->data = $data;
        $this->pdfFile = $pdfFile;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Nouvelle candidature - ' . $this->data['poste'])
                    ->view('emails.application')
                    ->attach($this->pdfFile->getRealPath(), [
                        'as' => 'Candidature_' . $this->data['nom'] . '_' . $this->data['prenom'] . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}