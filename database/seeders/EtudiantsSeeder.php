<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Important
use Illuminate\Support\Facades\Hash; // Si vous aviez des mots de passe

class EtudiantsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('etudiants')->insert([
            [
                // 'id' => 1, // Laravel gérera l'auto-incrément
                'nom' => 'vtrt',
                'prenom' => 'erc',
                'email' => 'ddecec@gmail.com',
                'telephone' => '34354646',
                'formation' => 'GIOIOO',
                'niveau' => 'Bac+3',
                'date_naissance' => '2025-04-10',
                'cv_path' => 'documents/cv/1744104114_vtrt_erc.pdf',
                'photo_path' => 'images/etudiants/1744104114_vtrt_erc.jpg',
                'created_at' => '2025-04-08 08:21:54',
                'updated_at' => '2025-04-08 08:21:54'
            ],
            [
                // 'id' => 2,
                'nom' => 'CZEZ',
                'prenom' => 'ECR',
                'email' => 'RC@GGAMIL.COM',
                'telephone' => '45366',
                'formation' => 'VRE',
                'niveau' => 'Bac+4',
                'date_naissance' => '2025-04-16',
                'cv_path' => '1744104289_CZEZ_ECR.pdf',
                'photo_path' => '1744104289_CZEZ_ECR.jpg',
                'created_at' => '2025-04-08 08:24:49',
                'updated_at' => '2025-04-08 08:24:49'
            ],
        ]);
    }
}