<?php

namespace Database\Seeders;

use App\Models\Kategorie;
use Illuminate\Database\Seeder;

class KategorieSeeder extends Seeder
{
        public function run(): void
    {
        Kategorie::factory()->count(6)->create();
    }
}
