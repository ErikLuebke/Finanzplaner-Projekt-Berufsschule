<?php

namespace Database\Seeders;

use App\Models\Kontobewegung;
use Illuminate\Database\Seeder;

class KontobewegungSeeder extends Seeder
{

    public function run(): void
    {
        Kontobewegung::factory()->count(30)->create();
    }
}
