<?php

namespace Database\Seeders;

use App\Models\Konto;
use Illuminate\Database\Seeder;

class KontoSeeder extends Seeder
{
    public function run(): void
    {
        Konto::factory()->count(10)->create();
    }
}
