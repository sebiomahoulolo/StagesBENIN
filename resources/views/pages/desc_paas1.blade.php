@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
<style>
   body {
        font-family: 'Times New Roman', Times, serif;
    }
        .section-title {
            color: #007bff;
            text-transform: uppercase;
            font-weight: bold;
        }
        .info-box {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            background-color: #f8f9fa;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .sub-title {
            font-weight: bold;
            color: #0056b3;
        }
    </style>

    <div class="container mt-5">
        <header class="text-center mb-5">
         
            <h3 class="section-title">Programme d’Accompagnement Professionnel et de Stages (PAPS)</h3>
            <p>Offrir une feuille de route claire et structurée aux étudiants pour leur intégration professionnelle.</p>
        </header>

        <!-- Appel à candidature -->
        <section>
            <h5 class="section-title">Sélection des cabinets , entreprises et centres de formation </h5>
            <h3 class="sub-title">1 - Conditions d’éligibilités</h3>
            <div class="info-box">
                <ul>
                    <li>Exister depuis au moins 2 ans</li>
                    <li>Être légalement constitués et en règle vis-à-vis des obligations fiscales et sociales</li>
                    <li>Disposer d’un siège social, d’équipements pédagogiques et d’outils de formation modernes</li>
                    <li>Proposer des formations en outils informatiques et logiciels professionnels adaptés aux besoins du marché</li>
                    <li>Avoir une capacité d’accueil suffisante pour assurer un suivi des stagiaires</li>
                </ul>
            </div>
        </section>

        <!-- Constitution du dossier -->
        <section>
            <h3 class="sub-title">2 - Constitution du Dossier de Candidature</h3>
            <div class="info-box">
                <ul>
                    <li>Lettre de demande d’agrément, adressée au Directeur Général</li>
                    <li>Statuts légaux (RCCM, IFU) et preuve d’existence depuis au moins 2 ans</li>
                    <li>Preuve d’agrément ministériel ou autorisation d’exercer</li>
                    <li>Description des formations proposées et attestation des formateurs qualifiés</li>
                    <li>Liste du matériel et des infrastructures disponibles</li>
                    <li>Références et expériences antérieures en formation professionnelle</li>
                    <li>Plan de suivi des stagiaires pendant et après la formation</li>
                    <li>CV des formateurs et preuves de leurs qualifications</li>
                    <li>Quittance des frais d’étude de dossier : <strong>35 000 FCFA</strong></li>
                </ul>
                <p><strong>Informations Bancaires :</strong></p>
                <ul>
                    <li><strong>NOM :</strong> FHC GROUPE SARL</li>
                    <li><strong>CODE BANQUE :</strong> BJ099</li>
                    <li><strong>CODE GUICHET :</strong> 01014</li>
                    <li><strong>N° COMPTE NSIA BANQUE :</strong> 260077012015</li>
                    <li><strong>MOTIF :</strong> Sélection Cabinet/Centre</li>
                </ul>
                <a href="https://me.fedapay.com/appel-cabinets-centre" class="btn btn-primary">Payez votre quittance en ligne</a>
            </div>
        </section>

        <!-- Critères -->
<section>
    <h3 class="sub-title">3 - Critères de Sélection et Notation des Cabinets</h3>
    <div class="info-box">
        <img src="{{ asset('assets/images/X1.webp') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
    </div>
</section>

<section>
    <h3 class="sub-title">4 - Domaines de Formation</h3>
    <div class="info-box">
        <img src="{{ asset('assets/images/X2.webp') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
    </div>
</section>

<section>
    <h3 class="sub-title">5 - CALENDRIER DE SÉLECTION DES CABINETS</h3>
    <div class="info-box">
        <img src="{{ asset('assets/images/x3.webp') }}" alt="Image de Cible du projet" style="width: 80%;  height: auto;">
    </div>
</section>

        <!-- Avantages -->
        <section>
            <h3 class="sub-title">6 - Avantages pour les Cabinets de Formation</h3>
            <div class="info-box">
                <ul>
                    <li>Accroissement du chiffre d’affaires et de la clientèle</li>
                    <li>Visibilité et crédibilité accrues</li>
                    <li>Opportunités de partenariats et de croissance</li>
                    <li>Diversification et amélioration des services</li>
                    <li>Statut de prestataire officiel de StagesBENIN</li>
                    <li>Reconnaissance auprès des entreprises et des institutions</li>
                </ul>
            </div>
        </section>

        <!-- Comment postuler -->
        <section>
            <h3 class="sub-title">7 - Comment postuler ?</h3>
            <div class="info-box">
                <p>Les cabinets doivent soumettre leur dossier via e-mail à <a href="mailto:depot@stagesbenin.com">depot@stagesbenin.com</a> en un fichier unique PDF ou au siège de StagesBENIN.</p>
                <p>Contact par WhatsApp : <strong>+229 01 41733175</strong></p>
            </div>
        </section>
             <a href="https://me.fedapay.com/appel-cabinets-centre" class="btn btn-primary">Payez votre quittance en ligne</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


@endsection