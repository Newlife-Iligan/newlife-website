<?php

namespace Database\Seeders;

use App\Models\Ministry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createMinistries();
    }

    public function createMinistries()
    {
        Ministry::firstOrCreate(['name'=>'Pastoral']);
        Ministry::firstOrCreate(['name'=>'Administration']);
        Ministry::firstOrCreate(['name'=>'Finance']);
        Ministry::firstOrCreate(['name'=>'Media and Creatives']);
        Ministry::firstOrCreate(['name'=>'Praise and Worship']);
        Ministry::firstOrCreate(['name'=>'Production']);
        Ministry::firstOrCreate(['name'=>'Young Adult']);
        Ministry::firstOrCreate(['name'=>'Youth']);
        Ministry::firstOrCreate(['name'=>'Kids']);
        Ministry::firstOrCreate(['name'=>'Sound and Lights']);
        Ministry::firstOrCreate(['name'=>'Ushering']);
        Ministry::firstOrCreate(['name'=>'New Life Community Care']);
    }
}
