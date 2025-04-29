<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Secteur;
use App\Models\Specialite;

class SecteurSpecialiteSeeder extends Seeder
{
    public function run()
    {
        $secteurs = [
            'Administration / Gestion / Ressources Humaines' => [
                'Administrateur système',
                'Assistant administratif',
                'Assistant de direction',
                'Assistant ressources humaines',
                'Cadre ressources humaines',
                'Chargé(e) de projet / Chef de projet',
                'Conseiller/conseillère en ressources humaines',
                'Directeur/directrice d\'établissement',
                'Directeur/directrice des ressources humaines',
                'Employé administratif',
                'Manager / Superviseur/superviseuse',
                'Réceptionniste',
                'Responsable administratif',
                'Responsable d\'exploitation',
                'Responsable des ressources humaines',
                'Secrétaire administratif'
            ],
            'Finance / Banque / Assurance / Comptabilité' => [
                'Agent d\'assurance',
                'Analyste crédit',
                'Analyste financier',
                'Auditeur/auditrice',
                'Cadre financier',
                'Comptable',
                'Conseiller/conseillère financier/financière',
                'Contrôleur de gestion',
                'Directeur/directrice financier/financière',
                'Expert-comptable',
                'Expert en assurance'
            ],
            'Marketing / Vente / Communication / Commerce' => [
                'Analyste commercial',
                'Assistant marketing',
                'Cadre marketing',
                'Caissier/caissière',
                'Chargé(e) d\'études',
                'Chargé(e) de clientèle',
                'Chargé(e) de communication',
                'Chef de produit',
                'Commercial',
                'Directeur/directrice commercial(e)',
                'Directeur/directrice marketing',
                'Expert en communication',
                'Expert en marketing digital',
                'Expert en relations publiques',
                'Responsable commercial',
                'Responsable marketing',
                'Vendeur/vendeuse'
            ],
            'Informatique / Technologie / Digital (IT)' => [
                'Analyste de données',
                'Concepteur UX/UI',
                'Développeur web',
                'Ingénieur en informatique',
                'Informaticien/informaticienne',
                'Programmeur/programmeuse',
                'Responsable informatique',
                'Spécialiste en cybersécurité',
                'Technicien/technicienne en informatique',
                'Webdesigner'
            ],
            'Santé / Social / Soins' => [
                'Éducateur/éducatrice spécialisé(e)',
                'Infirmier/infirmière',
                'Kinésithérapeute',
                'Médecin',
                'Opticien/opticienne',
                'Orthophoniste',
                'Pharmacien/pharmacienne',
                'Psychologue',
                'Sage-femme',
                'Secrétaire médical',
                'Technicien/technicienne de laboratoire',
                'Technicien/technicienne en radiologie',
                'Vétérinaire'
            ],
            'Construction / BTP / Artisanat / Architecture' => [
                'Architecte',
                'Conducteur/conductrice de travaux',
                'Maçon',
                'Menuisier/menuisière',
                'Monteur/monteuse',
                'Peintre',
                'Plombier/plombière',
                'Soudeur/soudeuse',
                'Ingénieur civil'
            ],
            'Arts / Culture / Média / Design' => [
                'Acteur/actrice',
                'Animateur/animatrice',
                'Bibliothécaire',
                'Décorateur/décoratrice',
                'Designer graphique',
                'Directeur/directrice artistique',
                'Graphiste',
                'Journaliste',
                'Musicien/musicienne',
                'Photographe',
                'Réalisateur/réalisatrice',
                'Styliste'
            ],
            'Éducation / Formation' => [
                'Conseiller/conseillère en formation',
                'Enseignant/enseignante',
                'Formateur/formatrice',
                'Professeur/professeure'
            ],
            'Ingénierie / Industrie / Technique / Maintenance' => [
                'Agent technique',
                'Ingénieur chimiste',
                'Ingénieur mécanique',
                'Ingénieur électrique',
                'Mécanicien/mécanicienne',
                'Responsable qualité',
                'Technicien/technicienne en maintenance'
            ],
            'Logistique / Transport' => [
                'Agent logistique',
                'Magasinier/magasinière',
                'Manutentionnaire',
                'Pilote',
                'Responsable logistique'
            ],
            'Tourisme / Hôtellerie / Restauration' => [
                'Agent de voyage',
                'Guide touristique',
                'Serveur/serveuse'
            ],
            'Agriculture / Agroalimentaire / Environnement / Recherche' => [
                'Agriculteur/agricultrice',
                'Ingénieur agronome',
                'Zoologiste'
            ],
            'Services à la personne / Beauté' => [
                'Coiffeur/coiffeuse',
                'Esthéticien/esthéticienne'
            ],
            'Juridique / Droit' => [
                'Avocat/avocate',
                'Juriste'
            ],
            'Sécurité' => [
                'Agent de sécurité',
                'Responsable sécurité'
            ],
            'Immobilier' => [
                'Agent immobilier'
            ],
            'Conseil / Services aux entreprises' => [
                'Conseiller/conseillère en gestion',
                'Traducteur/traductrice'
            ],
            'Artisanat / Commerce Spécialisé' => [
                'Boucher/bouchère'
            ]
        ];

        foreach ($secteurs as $secteurNom => $specialites) {
            $secteur = Secteur::create(['nom' => $secteurNom]);
            
            foreach ($specialites as $specialiteNom) {
                Specialite::create([
                    'secteur_id' => $secteur->id,
                    'nom' => $specialiteNom
                ]);
            }
        }
    }
} 