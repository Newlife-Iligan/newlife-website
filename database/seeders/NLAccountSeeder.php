<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NLAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=MemberRoleSeeder
     */
    public function run(): void
    {
        $this->createAccounts();
    }

    public function createAccounts()
    {
        MemberRole::firstOrCreate(['name' => 'Rental']);
        MemberRole::firstOrCreate(['name' => 'Pastoral Care']);
        MemberRole::firstOrCreate(['name' => 'Trainings/Conference/Meetings/Seminars']);
        MemberRole::firstOrCreate(['name' => 'Ushering']);
        MemberRole::firstOrCreate(['name' => 'Kinds Kingdom']);
        MemberRole::firstOrCreate(['name' => 'New Gen']);
        MemberRole::firstOrCreate(['name' => 'Admin']);
        MemberRole::firstOrCreate(['name' => 'Finance']);
    }
}
