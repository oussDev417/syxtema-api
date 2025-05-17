<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Recruitment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecruitmentFactory extends Factory
{
    protected $model = Recruitment::class;

    public function definition(): array
    {
        $countries = Country::pluck('id')->toArray();
        
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'file_pdf' => null,
            'status' => $this->faker->randomElement(['active', 'draft', 'closed']),
            'deadline' => $this->faker->dateTimeBetween('now', '+3 months'),
            'country_id' => $this->faker->randomElement($countries),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'deadline' => $this->faker->dateTimeBetween('now', '+2 months'),
            ];
        });
    }
}
