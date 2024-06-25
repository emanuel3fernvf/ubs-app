<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class seeder_2024_06_24_110953_register_permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Position::where('key', 'administrator')->first();

        $administratorPermissions = [
            ['key' => 'user', 'type' => 'read'],
            ['key' => 'user', 'type' => 'write'],
        ];

        foreach ($administratorPermissions as $permission) {
            $administrator->permissions()->updateOrCreate(
                $permission,
                $permission
            );
        }
    }
}
