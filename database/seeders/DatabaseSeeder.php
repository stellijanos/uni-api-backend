<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'firstname' => 'Janos',
            'lastname' => 'Stelli',
            'email' => 'janos@stellijanos.com',
            'birthDate' => '2003-12-23',
            'password' => Hash::make('123')
        ]);
    }
}
