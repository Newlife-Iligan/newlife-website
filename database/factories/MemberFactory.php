<?php

namespace Database\Factories;

use App\Models\MemberRole;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();
        $roles = MemberRole::pluck('name')->toArray();

        return [
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'nickname' => $faker->optional()->userName,
            'birthday' => $faker->date(),
            'contact_number' => $faker->phoneNumber,
            'facebook_url' => $faker->optional()->url,
            'ministry_id' => $faker->optional()->numberBetween(1, 10),
            'life_group_id' => $faker->optional()->numberBetween(1, 20),
            'address' => $faker->address,
            'profile_pic' => $faker->optional()->imageUrl(),
            'motto' => $faker->optional()->sentence,
            'bible_verse' => $faker->optional()->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => $faker->randomElement(['active', 'inactive', 'first timer']),
            'life_verse' => $faker->optional()->sentence,
            'email' => $faker->unique()->safeEmail,
            'role' => $faker->randomElement($roles),
        ];
    }
}


