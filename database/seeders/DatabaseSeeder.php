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
        $this->command->info('Début du seeding...');

        // Appeler les seeders pour chaque type d'utilisateur
        $this->call([
            AdminUserSeeder::class,       // Crée l'administrateur
            EtudiantsSeeder::class,       // Crée des utilisateurs étudiants et leurs profils
            EntreprisesSeeder::class,     // Crée des utilisateurs recruteurs et leurs entreprises
            //UserSeeder::class,
            //EntrepriseSeeder::class,
            SecteurSpecialiteSeeder::class,

           
            // EventsSeeder::class,      
            // SubscribersSeeder::class, 
            // ActualitesSeeder::class,
            // CatalogueSeeder::class,
            // RecrutementsSeeder::class,
                                       
        ]);

         $this->command->info('Seeding terminé avec succès !');
    }
}