<?php
namespace Database\Seeders;

use App\Models\SettingsModel;
use HourSeeder;
use Illuminate\Database\Seeder;
use RoomSeeder;
use SettingsSeeder;
use UserSeeder;

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
