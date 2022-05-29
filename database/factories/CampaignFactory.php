<?php

namespace Database\Factories;

use App\Models\CampaignType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
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
            'description' => $this->faker->text(1000),
            'status' => $this->faker->boolean(),
            'campaign_type_id' => CampaignType::factory()->create()->id
        ];
    }
}
