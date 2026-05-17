<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kategorie;
use App\Models\Konto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
/*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
*/
        Kategorie::factory()->create([
            'bezeichnung' => 'Haushalt'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Miete'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Gehalt'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Reise'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Freizeit'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Tanken'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Einkauf'
        ]);
        Kategorie::factory()->create([
            'bezeichnung' => 'Abonnement'
        ]);

        Konto::factory()->create([
            'name' => 'Sparkasse'
        ]);
        Konto::factory()->create([
            'name' => 'PayPal'
        ]);
        Konto::factory()->create([
            'name' => 'VR-Bank'
        ]);
        
        $this->call(KontobewegungSeeder::class);
    }
}
