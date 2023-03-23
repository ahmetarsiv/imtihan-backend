<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Support;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Support>
 */
class SupportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->title,
            'message' => $this->faker->text,
            'is_active' => Support::STATUS_INACTIVE,
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
        ];
    }
}
