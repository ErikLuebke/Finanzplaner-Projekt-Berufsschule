<?php

namespace Database\Factories;

use App\Models\Kontobewegung;
use App\Models\Konto;
use App\Models\Kategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class KontobewegungFactory extends Factory {

    protected $model = Kontobewegung::class;

    public function definition(): array
    {
        $kontoIds = Konto::pluck('kontoid')->toArray();
        $kontoId = !empty($kontoIds) ? $this->faker->randomElement($kontoIds) : null;

        $kategorieIds = Kategorie::pluck('kategorieid')->toArray();
        $kategorieId = !empty($kategorieIds) ? $this->faker->randomElement($kategorieIds) : null; 
        
        return [
            'konto_id' => $kontoId,
            'kategorie_id' => $kategorieId,
            'date' => $this->faker->date(),
            'fix' => $this->faker->boolean(),
            'geldwert' => $this->faker->randomFloat(2, -500, 1700),
        ];
    }
}