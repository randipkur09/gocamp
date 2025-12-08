<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Tenda', 'slug' => 'tenda'],
            ['name' => 'Carrier / Tas Gunung', 'slug' => 'carrier-tas-gunung'],
            ['name' => 'Matras / Sleeping Bag', 'slug' => 'matras-sleeping-bag'],
            ['name' => 'Peralatan Masak', 'slug' => 'peralatan-masak'],
            ['name' => 'Pakaian Gunung', 'slug' => 'pakaian-gunung'],
            ['name' => 'Sepatu & Sandal Gunung', 'slug' => 'sepatu-sandal-gunung'],
            ['name' => 'Peralatan Navigasi', 'slug' => 'peralatan-navigasi'],
            ['name' => 'Lampu & Senter', 'slug' => 'lampu-senter'],
            ['name' => 'Alat Safety', 'slug' => 'alat-safety'],
            ['name' => 'Perlengkapan Lainnya', 'slug' => 'perlengkapan-lainnya'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name']],
                ['slug' => $cat['slug']]
            );
        }
    }
}
