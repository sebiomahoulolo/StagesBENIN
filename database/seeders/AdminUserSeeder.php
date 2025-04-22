<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Importer User
use Illuminate\Support\Facades\Hash; // Importer Hash

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@stagesbenin.com' // Email unique de l'admin
            ],
            [
                'name' => 'Admin StagesBenin',
                'email' => 'admin@stagesbenin.com',
                'password' => Hash::make('password'), // **Changez ce mot de passe !**
                'role' => User::ROLE_ADMIN, // Utiliser la constante du modèle
                'email_verified_at' => now(), // Marquer comme vérifié
            ]
        );
    }
}