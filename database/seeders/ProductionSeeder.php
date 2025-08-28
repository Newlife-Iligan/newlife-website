<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use App\Models\Ministry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            MinistrySeeder::class,
            MemberRoleSeeder::class,
            NLAccountSeeder::class,
        ]);
    }
}
