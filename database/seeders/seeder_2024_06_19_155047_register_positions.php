<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class seeder_2024_06_19_155047_register_positions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::create([
            'name' => 'Recepcionista',
            'key' => 'receptionist',
            'status' => 'active',
        ]);

        Position::create([
            'name' => 'Médico',
            'key' => 'doctor',
            'status' => 'active',
        ]);

        Position::create([
            'name' => 'Administrador',
            'key' => 'administrator',
            'status' => 'active',
        ]);
    }
}
