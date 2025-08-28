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
        MemberRole::firstOrCreate(['name' => 'Admin', 'color' => "rgb(235, 169, 224)"]);
        MemberRole::firstOrCreate(['name' => 'Heads', 'color' => "rgb(209, 169, 169)"]);
        MemberRole::firstOrCreate(['name' => 'Volunteer', 'color' => "rgb(237, 221, 138)"]);
        MemberRole::firstOrCreate(['name' => 'Member', 'color' => "rgb(196, 73, 73)"]);
        MemberRole::firstOrCreate(['name' => 'Staff', 'color' => "rgb(101, 158, 232)"]);
        MemberRole::firstOrCreate(['name' => 'Finance Staff', 'color' => "rgb(74, 250, 191)"]);
        MemberRole::firstOrCreate(['name' => 'Pastors', 'color' => "rgb(57, 199, 22)"]);
    }
}
