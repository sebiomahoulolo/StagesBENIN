<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Appel d\'Offre',
                'slug' => 'appel_offre'
            ],
            [
                'name' => 'Avis d\'Attribution',
                'slug' => 'avis_attribution'
            ],
            [
                'name' => 'Avis de Manifestation d\'Intérêt',
                'slug' => 'manifestation_interet'
            ],
            [
                'name' => 'Résultats',
                'slug' => 'resultats'
            ],
            [
                'name' => 'Autre Publication',
                'slug' => 'autre_publication'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 