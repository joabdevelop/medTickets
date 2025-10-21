<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ]);
         User::factory()->create([
            'name' => 'joabe',
            'email' => 'joabe@gmail.com',
            'password' =>  Hash::make('123456'),
        ]);
        User::factory()->create([
            'name' => 'maria',
            'email' => 'maria@gmail.com',
            'password' => Hash::make('123456')
        ]);
        User::factory()->create([
            'name' => 'Mazarope',
            'email' => 'mazarope@gmail.com',
            'password' => Hash::make('123456')
        ]);

        User::factory()->create([
            'name' => 'Fernanda',
            'email' => 'fernanda@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
