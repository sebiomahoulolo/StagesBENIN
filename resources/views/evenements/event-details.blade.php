<!-- resources/views/evenements/event-details.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket - {{ $event->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
            background-color: #f9f9f9;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .ticket {
            border: 2px solid #0d6efd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 12px;
            position: relative;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .ticket-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.05;
            object-fit: cover;
            z-index: 0;
        }
        .ticket-header {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: white;
            padding: 8px;
            margin: -12px -12px 12px -12px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            text-align: center;
            position: relative;
            z-index: 1;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .ticket-header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
        }
        .ticket-body {
            display: flex;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .ticket-info {
            width: 65%;
            padding-right: 10px;
        }
        .qr {
            width: 35%;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .qr svg {
            width: 100px;
            height: 100px;
        }
        .qr p {
            margin: 5px 0 0 0;
            font-size: 9px;
            font-style: italic;
            color: #666;
        }
        .logo {
            position: absolute;
            top: 10px;
            right: 10px;
            opacity: 0.08;
            width: 120px;
            z-index: 1;
        }
        .ticket-footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px dashed #ccc;
            padding-top: 8px;
            position: relative;
            z-index: 1;
        }
        .ticket-copy {
            margin-top: 25px;
            border: 1px dashed #666;
            padding: 8px;
            font-size: 11px;
            background-color: #fff;
            position: relative;
        }
        .ticket-copy h3 {
            margin: 0 0 8px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 4px;
            vertical-align: top;
            font-size: 11px;
        }
        table td:first-child {
            width: 80px;
        }
        .company-info {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }
        .company-info p {
            margin: 2px 0;
        }
        .dotted-line {
            border-top: 2px dotted #666;
            margin: 20px 0;
            position: relative;
        }
        .dotted-line::after {
            content: "✂";
            position: absolute;
            top: -10px;
            left: 50%;
            background: #f9f9f9;
            padding: 0 10px;
            color: #666;
        }
        .ref-number {
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
            background-color: #f8f9fa;
            padding: 2px 4px;
            border-radius: 3px;
            border: 1px solid #dee2e6;
        }
        .event-date {
            color: #0d6efd;
            font-weight: bold;
        }
        .price-tag {
            color: #198754;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Copie client -->
        <div class="ticket">
         <div class="ticket-header">
                <h1>{{ $event->title }}</h1>
            </div>
            
            <!-- Logo en filigrane -->
            <img class="logo" src="{{ public_path('assets/images/stagebenin.png') }}" alt="StagesBENIN Logo">
            
            <div class="ticket-body">
                <div class="ticket-info">
                    <h3>COPIE CLIENT - {{ $event->title }}</h3>
                    <table>
                        <tr>
                            <td><strong>Date:</strong></td>
                            <td class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Lieu:</strong></td>
                            <td>{{ $event->location }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td>{{ $event->type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Prix:</strong></td>
                            <td class="price-tag">{{ number_format($event->ticket_price, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <td><strong>Référence:</strong></td>
                            <td><span class="ref-number">{{ strtoupper(substr(md5($event->id . time()), 0, 10)) }}</span></td>
                        </tr>
                    </table>
                </div>
                
            
           <div class="ticket-footer" >
    <p>Veuillez présenter ce ticket à l'entrée, Ticket généré le {{ now()->format('d/m/Y à H:i') }}</p>
   
</div>

        </div>
        
        <div class="dotted-line"></div>
        
        <!-- Copie entreprise -->
        <div class="ticket-copy">
            <h3>COPIE ORGANISATEUR - {{ $event->title }}</h3>
            <table>
                <tr>
                    <td><strong>Référence:</strong></td>
                    <td><span class="ref-number">{{ strtoupper(substr(md5($event->id . time()), 0, 10)) }}</span></td>
                </tr>
                <tr>
                    <td><strong>Date:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Prix:</strong></td>
                    <td class="price-tag">{{ number_format($event->ticket_price, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
        </div>
        
        <div class="company-info">
            <p>StagesBENIN - Votre partenaire événementiel, Email: contact@stagesbenin.com | Tél: +229 01 66 69 39 56</p>
        </div>
    </div>
</body>
</html>