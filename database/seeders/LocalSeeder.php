<?php

namespace Database\Seeders;

use App\Models\LifeGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserAdminSeeder::class,
            LifeGroupSeeder::class,
            MinistrySeeder::class,
            MemberRoleSeeder::class,
            NLAccountSeeder::class,
            MemberSeeder::class
        ]);
    }
}
