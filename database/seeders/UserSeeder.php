<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'dokter',
            'email' => 'dokter@gmail.com',
            'password' => 'dokter123',
            'role' => 'dokter',
        ]);

        User::factory()->create([
            'name' => 'lab-1',
            'email' => 'lab@gmail.com',
            'password' => 'petugaslab',
            'role' => 'petugas_lab',
        ]);
    }
}
