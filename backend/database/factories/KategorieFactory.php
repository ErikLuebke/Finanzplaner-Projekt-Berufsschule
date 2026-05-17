<?php

namespace Database\Factories;

use App\Models\Kategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategorieFactory extends Factory {

    protected $model = Kategorie::class;
    public function definition(): array 
    {
        return [
           'bezeichnung' => $this->faker->unique()->word(), 
        ];
    }

}