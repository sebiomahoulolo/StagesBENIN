    @extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
    
    
    <style>
        

        .card-custom {
            background: linear-gradient(135deg, #007BFF, #0056b3);
            color: white;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }
        .card-custom a {
            color: #0000ff;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
            transition: color 0.3s ease;
            background: white;
            padding: 10px

        }
        .card-custom a:hover {
            color:rgb(151, 139, 7);
        }
        .icon {
            font-size: 30px;
            margin-bottom: 10px;
        }
    </style>

<div class="hero-section">
    <div class="hero-overlay">
        <h1>Catalogue des entreprises</h1>
    </div>
</div>

<div class="container mt-4">
        <div class="row g-4">
            <!-- EBENI EVENTS -->
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-calendar-alt icon"></i>
                    <h5><strong>EBENI EVENTS</strong></h5>
                    <p>Plongez dans une expérience d'événementiel empreinte de bien-être et de principes avec Aebeni Events.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>13 février 2024</small></p>
                </div>
            </div>

            <!-- SMT 
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-truck-loading icon"></i>
                    <h5><strong>SMT</strong></h5>
                    <p>SMT, votre commissionnaire d'engins de chantier dédié à simplifier vos opérations de construction.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>26 janvier 2024</small></p>
                </div>
            </div>

        
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-tools icon"></i>
                    <h5><strong>CONSODATE SARL</strong></h5>
                    <p>Votre partenaire de confiance en quincaillerie générale et matériaux de construction.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>26 janvier 2024</small></p>
                </div>
            </div>

        
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-utensils icon"></i>
                    <h5><strong>ZMC SARL</strong></h5>
                    <p>Explorez le concept novateur de ZMC SARL, où la cuisine et la coiffure fusionnent harmonieusement.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>24 janvier 2024</small></p>
                </div>
            </div>

           
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-shield-alt icon"></i>
                    <h5><strong>VOLCAN SECURITE</strong></h5>
                    <p>Votre partenaire de confiance dans le domaine du gardiennage et de la sécurité.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>24 janvier 2024</small></p>
                </div>
            </div>

            
            <div class="col-md-4">
                <div class="card-custom p-3 text-center">
                    <i class="fas fa-paint-brush icon"></i>
                    <h5><strong>EBENI EVENTS</strong></h5>
                    <p>Votre partenaire créatif pour la décoration et la coordination d’événements exceptionnels.</p>
                    <a href="#">CONSULTER »</a>
                    <p class="mt-3"><small>24 janvier 2024</small></p>
                </div>
            </div>-->
        </div>
    </div>

 


 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection