<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductoModel;
use Faker\Generator as Faker;

class ProductoModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $filepath = storage_path('app\public\uploads');
        return [
            'nombre' => $this->faker->sentence(3),
            'disponibilidad' => $this->faker->numberBetween($min = 0, $max = 1),
            'descripcion' => $this->faker->text,
            'precio' => $this->faker->numberBetween($min = 5000, $max = 70000),
            'imagen' => $this->faker->imageUrl(400, 300, null, false),
            'id_familia' => $this->faker->numberBetween($min = 1, $max = 4)
        ];
    }
}
