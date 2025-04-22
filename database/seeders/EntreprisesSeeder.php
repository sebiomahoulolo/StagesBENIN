<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EntreprisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Définir les données des recruteurs/entreprises exemples
        $entreprisesData = [
            [
                'user_name' => 'David AKOTO', // Nom du contact recruteur
                'user_email' => 'david.akoto@techsolutions.bj', // Email de connexion du recruteur
                'user_password' => 'password',
                'nom_entreprise' => 'Tech Solutions Bénin',
                'email_entreprise' => 'contact@techsolutions.bj', // Email public entreprise
                'telephone_entreprise' => '21001122',
                'secteur' => 'Informatique - Développement Web',
                'adresse' => 'Lot 123, Zongo, Cotonou',
                'description' => 'Leader en solutions logicielles innovantes au Bénin.',
                'site_web' => 'https://techsolutions.bj',
            ],
            [
                'user_name' => 'Elise PADONOU',
                'user_email' => 'elise.padonou@agroplus.com',
                'user_password' => 'password',
                'nom_entreprise' => 'AgroPlus Sarl',
                'email_entreprise' => 'info@agroplus.com',
                'telephone_entreprise' => '22334455',
                'secteur' => 'Agro-alimentaire',
                'adresse' => 'Quartier Haie Vive, Parakou',
                'description' => 'Transformation et commercialisation de produits agricoles locaux.',
                'site_web' => 'https://agroplus.com',
            ],
        ];

        foreach ($entreprisesData as $data) {
             // Utiliser une transaction pour assurer la création cohérente User + Entreprise
             DB::transaction(function () use ($data) {
                 // 1. Créer l'utilisateur (Recruteur)
                 $user = User::create([
                     'name' => $data['user_name'],
                     'email' => $data['user_email'],
                     'password' => Hash::make($data['user_password']),
                     'role' => User::ROLE_RECRUTEUR, // Utiliser la constante du modèle User
                     'email_verified_at' => now(), // Marquer comme vérifié pour les tests
                 ]);

                 // 2. Créer le profil entreprise lié
                 Entreprise::create([
                     'user_id' => $user->id, // Lier à l'utilisateur créé
                     'nom' => $data['nom_entreprise'],
                     'secteur' => $data['secteur'],
                     'description' => $data['description'],
                     'adresse' => $data['adresse'],
                     'email' => $data['email_entreprise'],
                     'telephone' => $data['telephone_entreprise'],
                     'site_web' => $data['site_web'],
                     'contact_principal' => $data['user_name'], // Utiliser le nom du user comme contact
                     // logo_path est null par défaut
                 ]);
             });
        }

        $this->command->info('Seeding des utilisateurs recruteurs/entreprises terminé.');
    }
}