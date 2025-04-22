<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Important

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('events')->insert([
            [
                // 'id' => 19,
                'title' => 'Hackathon 2025',
                'description' => 'Un hackathon de 48h pour les développeurs du Bénin',
                'start_date' => '2025-05-10 08:00:00',
                'end_date' => '2025-05-12 08:00:00',
                'location' => 'Cotonou, EtriLabs',
                'type' => 'Hackathon',
                'max_participants' => 100,
                'image' => 'hackathon.jpg',
                'created_at' => '2025-04-07 17:43:41',
                'updated_at' => '2025-04-07 17:43:41'
            ],
            [
                // 'id' => 20,
                'title' => 'Séminaire sur la Cybersécurité',
                'description' => 'Atelier pratique sur les enjeux de la sécurité numérique',
                'start_date' => '2025-06-05 09:00:00',
                'end_date' => '2025-06-05 16:00:00',
                'location' => 'Parakou, Les Cours Sonou',
                'type' => 'Séminaire',
                'max_participants' => 80,
                'image' => 'cybersecu.jpg',
                'created_at' => '2025-04-07 17:43:41',
                'updated_at' => '2025-04-07 17:43:41'
            ],
             [
                //  'id' => 21,
                 'title' => 'TYYT',
                 'description' => 'FR  RGLRK?K', // Attention aux caractères spéciaux
                 'start_date' => '2025-04-08 10:25:00',
                 'end_date' => '2025-04-20 10:25:00',
                 'location' => 'PK',
                 'type' => 'Formation',
                 'max_participants' => 10000,
                 'image' => 'images/events/1744104385.png',
                 'created_at' => '2025-04-08 08:26:25',
                 'updated_at' => '2025-04-08 08:26:25'
             ],
        ]);
    }
}