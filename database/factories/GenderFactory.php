<?php

namespace Database\Factories;

use App\Models\CampaignType;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->name()
        ];
    }
}
