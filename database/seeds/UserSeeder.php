<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Daniela Montechiare Gentil',
            'username' => '@espacojuntos',
            'email' => 'danielamontechiaregentil@gmail.com',
            'password' => Hash::make('888123'),
            'phone' => '21986022928'
        ]);

        DB::table('users')->insert([
            'name' => 'Anderson Barbosa dos Santos',
            'username' => 'dev.anderson',
            'email' => 'dev.anderson.santos@gmail.com',
            'password' => Hash::make('!Q@W#E4r5t6y'),
            'phone' => '21976662004'
        ]);
    }
}
