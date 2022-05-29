<?php

namespace Database\Factories;

use App\Models\Study;
use Illuminate\Support\Str;
use App\Models\CampaignType;
use App\Models\StudyChannel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'channel_id'       => StudyChannel::random()->id,
            'study_id'         => Study::random()->id,
            'status_id',
            'gender_id',
            'reference_number' => Str::random(10),
            'name'             => $this->faker->name(),
            'email'            => $this->faker->email(),
            'age',             => 
            'ethnicity',
            'phone_number',
            'site',
            'site_distance',
            'opt_in',
            'contact_date',
            'confirmation_date',
            'symptoms_date',
            'suspect_date',
            'form_sent',
            'screening_data',
            'country',
            'city',
            'postcode',
            'address_line_1',
            'address_line_2',
            'birthdate', 
        ];
    }
}
