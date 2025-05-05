<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Secteur;
use App\Models\Specialite;

class SecteursEtSpecialitesSeeder extends Seeder
{
    public function run()
    {
        $secteurs = [
            'Informatique et Numérique' => [
                'Développement Web',
                'Développement Mobile',
                'Intelligence Artificielle',
                'Cybersécurité',
                'Réseaux et Systèmes'
            ],
            'Commerce et Marketing' => [
                'Marketing Digital',
                'Commerce International',
                'Vente et Distribution',
                'Communication',
                'Relations Publiques'
            ],
            'Finance et Comptabilité' => [
                'Comptabilité',
                'Audit',
                'Finance d\'entreprise',
                'Contrôle de gestion',
                'Banque et Assurance'
            ],
            'Ingénierie' => [
                'Génie Civil',
                'Génie Électrique',
                'Génie Mécanique',
                'Génie Industriel',
                'BTP'
            ],
            'Santé' => [
                'Médecine',
                'Pharmacie',
                'Soins infirmiers',
                'Santé publique',
                'Laboratoire médical'
            ]
        ];

        foreach ($secteurs as $nomSecteur => $specialites) {
            $secteur = Secteur::create(['nom' => $nomSecteur]);
            
            foreach ($specialites as $nomSpecialite) {
                Specialite::create([
                    'secteur_id' => $secteur->id,
                    'nom' => $nomSpecialite
                ]);
            }
        }
    }
}
