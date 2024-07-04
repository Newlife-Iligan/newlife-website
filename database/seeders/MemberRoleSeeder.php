<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=MemberRoleSeeder
     */
    public function run(): void
    {
        $this->createRoles();
    }

    public function createRoles()
    {
        MemberRole::firstOrCreate(['name' => 'Admin']);
        MemberRole::firstOrCreate(['name' => 'Heads']);
        MemberRole::firstOrCreate(['name' => 'Volunteer']);
        MemberRole::firstOrCreate(['name' => 'Member']);
        MemberRole::firstOrCreate(['name' => 'Staff']);
    }
}
