<?php

namespace Database\Seeders;

use App\Models\LifeGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LifeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createLifeGroups();
    }

    public function createLifeGroups()
    {
        LifeGroup::firstOrCreate(['name' => 'Life Group 1']);
        LifeGroup::firstOrCreate(['name' => 'Life Group 2']);
        LifeGroup::firstOrCreate(['name' => 'Life Group 3']);
        LifeGroup::firstOrCreate(['name' => 'Life Group 4']);
    }
}
