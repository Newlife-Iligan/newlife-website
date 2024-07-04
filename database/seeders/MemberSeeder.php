<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use App\Models\Members;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Members::factory()
                ->count(50)
                ->create();
    }
}
