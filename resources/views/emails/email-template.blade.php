{{-- resources/views/emails/template.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $sujet ?? 'StagesBENIN' }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 30px; color: #333;">

    {{-- Tête --}}
    <div style="text-align:center; margin-bottom:30px;">
        <img src="https://stagesbenin.com/assets/images/stagebenin.png" alt="StagesBENIN" style="max-width:200px;">
        <p style="color:#2c3e50; font-size:16px;">
            Votre passerelle d'insertion professionnelle et de visibilité digitale par excellence !
        </p>
    </div>

    {{-- Corps --}}
    <div style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        {!! $contenu !!}
    </div>

    {{-- Pied --}}
    <div style="text-align:center; margin-top:30px; font-size:14px; color:#555;">
        <p>Contact : contact@stagesbenin.com</p>
        <p>
            <a href="https://www.facebook.com/stagesbenin" style="margin: 0 10px;">Facebook</a>
            <a href="https://www.linkedin.com/company/stagesbenin/" style="margin: 0 10px;">LinkedIn</a>
            <a href="https://www.tiktok.com/@stagesbenin6" style="margin: 0 10px;">TikTok</a>
            <a href="https://wa.me/22966693956" style="margin: 0 10px;">WhatsApp</a>
        </p>
    </div>

</body>
</html>
