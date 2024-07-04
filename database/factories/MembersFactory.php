<?php

namespace Database\Factories;

use App\Models\LifeGroup;
use App\Models\MemberRole;
use App\Models\Ministry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MembersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = MemberRole::pluck('id')->toArray();
        $ministryIds = Ministry::pluck('id')->toArray();
        $lifeGroupIds = LifeGroup::pluck('id')->toArray();

        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'nickname' => $this->faker->optional()->userName,
            'birthday' => $this->faker->dateTimeBetween('1990-01-01', '2010-12-31')->format('Y-m-d'),
            'contact_number' => $this->faker->phoneNumber,
            'facebook_url' => $this->faker->optional()->url,
            'ministry_id' => $this->faker->boolean(70) && !empty($ministryIds)
                ? $this->faker->randomElement($ministryIds)
                : null,
            'life_group_id' => !empty($lifeGroupIds)
                ? $this->faker->randomElement($lifeGroupIds)
                : null,
            'address' => $this->faker->address,
            'profile_pic' => $this->faker->optional()->imageUrl(),
            'motto' => $this->faker->optional()->sentence,
            'bible_verse' => $this->faker->optional()->sentence,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'first timer']),
            'life_verse' => $this->faker->optional()->sentence,
            'email' => $this->faker->unique()->safeEmail,
            'role' => $this->faker->randomElement($roles),
        ];
    }
}
