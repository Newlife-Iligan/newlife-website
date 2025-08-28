<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use App\Models\NlAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NLAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=NLAccountSeeder
     */
    public function run(): void
    {
        $this->createAccounts();
    }

    public function createAccounts()
    {
        NlAccount::firstOrCreate(['name' => 'Rental']);
        NlAccount::firstOrCreate(['name' => 'Pastoral Care']);
        NlAccount::firstOrCreate(['name' => 'Trainings/Conference/Meetings/Seminars']);
        NlAccount::firstOrCreate(['name' => 'Ushering']);
        NlAccount::firstOrCreate(['name' => 'Kinds Kingdom']);
        NlAccount::firstOrCreate(['name' => 'New Gen']);
        NlAccount::firstOrCreate(['name' => 'Admin']);
        NlAccount::firstOrCreate(['name' => 'Finance']);
    }
}
