<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gardez ceci si vous utilisez des factories pour les utilisateurs de test
        // \App\Models\User::factory(10)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Appeler vos seeders spécifiques
        $this->call([
            EtudiantsSeeder::class,
            EventsSeeder::class,
            SubscribersSeeder::class,
            // Ajoutez ici d'autres seeders si vous en créez (ex: ActualitesSeeder, etc.)
        ]);
    }
}