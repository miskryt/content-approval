<?php

namespace Database\Factories;

use App\Models\CampaignStatus;
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
            'name' => $this->faker->company(),
            'description' => $this->faker->text(),
            'long_description' => $this->faker->realText(),
            'campaign_status_id' => function(){
                return CampaignStatus::where('name', 'Active')->first()->id;
            }
        ];
    }
}

