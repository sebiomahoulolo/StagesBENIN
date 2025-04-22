<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Important

class SubscribersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscribers')->insert([
            [
                // 'id' => 1,
                'email' => 'sebiomahoulolo4@gmail.com',
                'created_at' => '2025-04-02 09:51:08',
                'updated_at' => '2025-04-02 09:51:08'
            ],
            [
                // 'id' => 2,
                'email' => 'mahoulolosebio4@gmail.com',
                'created_at' => '2025-04-02 09:54:47',
                'updated_at' => '2025-04-02 09:54:47'
            ],
            [
                // 'id' => 3,
                'email' => '\'sebiomahoulolo4@gmail.com', // Attention: Le ' au début vient du dump SQL. A nettoyer si c'est une erreur.
                'created_at' => '2025-04-02 09:58:50',
                'updated_at' => '2025-04-02 09:58:50'
            ],
            [
                // 'id' => 4,
                'email' => 'mahoulolosebio4@gmail.coms', // Attention: Le 's' à la fin vient du dump SQL. A nettoyer si c'est une erreur.
                'created_at' => '2025-04-02 10:16:31',
                'updated_at' => '2025-04-02 10:16:31'
            ],
            [
                // 'id' => 5,
                'email' => 'mahoulolosebio24@gmail.com',
                'created_at' => '2025-04-02 13:03:05',
                'updated_at' => '2025-04-02 13:03:05'
            ],
        ]);
    }
}