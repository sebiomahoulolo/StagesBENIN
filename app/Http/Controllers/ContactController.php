<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class ContactController extends Controller
{
    public function sendContactForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            
            $mail = new PHPMailer(true);      
            $mail->isSMTP();
            $mail->Host = 'smtp.exemple.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'fhclocation@gmail.com'; 
            $mail->Password = 'wqzz qewl anfo ymaj'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            
            $mail->setFrom($request->email, $request->name);
            $mail->addAddress('fhclocation@gmail.com');
            $mail->Subject = $request->subject;
            $mail->Body = $request->message;

            $mail->setFrom('fhclocation@gmail.com', 'Nouveau message du formulaire de contact');
            $mail->send();
            return back()->with('success', 'Votre message a été envoyé avec succès.');
        } catch (Exception $e) {
            return back()->with('error', "L'email n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}");
        }
    }
}
