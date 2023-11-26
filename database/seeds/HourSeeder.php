<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hours')->insert(['hour' => '07:00:00']);
        DB::table('hours')->insert(['hour' => '08:00:00']);
        DB::table('hours')->insert(['hour' => '09:00:00']);
        DB::table('hours')->insert(['hour' => '10:00:00']);
        DB::table('hours')->insert(['hour' => '11:00:00']);
        DB::table('hours')->insert(['hour' => '12:00:00']);
        DB::table('hours')->insert(['hour' => '13:00:00']);
        DB::table('hours')->insert(['hour' => '14:00:00']);
        DB::table('hours')->insert(['hour' => '15:00:00']);
        DB::table('hours')->insert(['hour' => '16:00:00']);
        DB::table('hours')->insert(['hour' => '17:00:00']);
        DB::table('hours')->insert(['hour' => '18:00:00']);
        DB::table('hours')->insert(['hour' => '19:00:00']);
        DB::table('hours')->insert(['hour' => '20:00:00']);
        DB::table('hours')->insert(['hour' => '21:00:00']);
    }
}
