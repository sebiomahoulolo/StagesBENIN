<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EtudiantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Définir les données des étudiants exemples
        $etudiantsData = [
            [
                'prenom' => 'Amina',
                'nom' => 'SOGLO',
                'email' => 'amina.soglo@example.com', // Email unique pour la connexion
                'password' => 'password', // Mot de passe par défaut
                'telephone' => '97001122',
                'formation' => 'Génie Logiciel',
                'niveau' => 'Licence 3',
                'date_naissance' => '2003-05-15',
            ],
            [
                'prenom' => 'Bio',
                'nom' => 'GUERA',
                'email' => 'bio.guera@example.com',
                'password' => 'password',
                'telephone' => '66998877',
                'formation' => 'Réseaux et Télécommunications',
                'niveau' => 'Master 1',
                'date_naissance' => '2001-11-20',
            ],
            [
                'prenom' => 'Carine',
                'nom' => 'HOUNSOOU',
                'email' => 'carine.hounsou@example.com',
                'password' => 'password',
                'telephone' => '51234567',
                'formation' => 'Marketing Digital',
                'niveau' => 'Licence 2',
                'date_naissance' => '2004-02-10',
            ],
        ];

        foreach ($etudiantsData as $data) {
            // Utiliser une transaction pour assurer la création cohérente User + Etudiant
            DB::transaction(function () use ($data) {
                // 1. Créer l'utilisateur
                $user = User::create([
                    'name' => $data['prenom'] . ' ' . $data['nom'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'role' => User::ROLE_ETUDIANT, // Utiliser la constante du modèle User
                    'email_verified_at' => now(), // Marquer comme vérifié pour les tests
                ]);

                // 2. Créer le profil étudiant lié
                Etudiant::create([
                    'user_id' => $user->id, // Lier à l'utilisateur créé
                    'nom' => $data['nom'],
                    'prenom' => $data['prenom'],
                    'email' => $data['email'], // Peut être redondant, mais on le garde pour l'instant
                    'telephone' => $data['telephone'],
                    'formation' => $data['formation'],
                    'niveau' => $data['niveau'],
                    'date_naissance' => $data['date_naissance'],
                    // cv_path et photo_path sont null par défaut
                ]);
            });
        }

         $this->command->info('Seeding des utilisateurs étudiants terminé.');
    }
}