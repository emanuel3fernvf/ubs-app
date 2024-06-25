<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class seeder_2024_06_19_161024_register_permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Position::where('key', 'administrator')->first();

        $administratorPermissions = [
            ['key' => 'professional', 'type' => 'read'],
            ['key' => 'professional', 'type' => 'write'],

            ['key' => 'specialty', 'type' => 'read'],
            ['key' => 'specialty', 'type' => 'write'],

            ['key' => 'unit', 'type' => 'read'],
            ['key' => 'unit', 'type' => 'write'],
        ];

        foreach ($administratorPermissions as $permission) {
            $administrator->permissions()->updateOrCreate(
                $permission,
                $permission
            );
        }

        $doctor = Position::where('key', 'doctor')->first();

        $doctorPermissions = [
            ['key' => 'patient', 'type' => 'read'],

            ['key' => 'assessments', 'type' => 'read'],
            ['key' => 'assessments', 'type' => 'write'],
        ];

        foreach ($doctorPermissions as $permission) {
            $doctor->permissions()->updateOrCreate(
                $permission,
                $permission
            );
        }

        $receptionist = Position::where('key', 'receptionist')->first();

        $receptionistPermissions = [
            ['key' => 'patient', 'type' => 'read'],
            ['key' => 'patient', 'type' => 'write'],

            ['key' => 'schedule', 'type' => 'read'],
            ['key' => 'schedule', 'type' => 'write'],
        ];

        foreach ($receptionistPermissions as $permission) {
            $receptionist->permissions()->updateOrCreate(
                $permission,
                $permission
            );
        }
    }
}
