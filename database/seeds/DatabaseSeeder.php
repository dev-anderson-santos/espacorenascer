<?php

use App\Models\SettingsModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            HourSeeder::class,
            RoomSeeder::class,
            SettingsSeeder::class,
        ]);
    }
}
