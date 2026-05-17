<?php

namespace Database\Factories;

use App\Models\Konto;
use Illuminate\Database\Eloquent\Factories\Factory;

class KontoFactory extends Factory {

    protected $model = Konto::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}