<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class seeder_2024_06_25_102012_register_user_admin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admPosition = Position::where('key', 'administrator')->first();

        $user = User::where('email', 'admin@ubsapp.com')->first();

        if ($user) {
            $user->update([
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]);
        } else {
            $user = User::create([
                'name' => 'Administrador',
                'email' => 'admin@ubsapp.com',
                'password' => Hash::make('12345678'),
                'status' => 'active',
            ]);
        }

        $user->modelPosition()->updateOrCreate(
            ['model_id' => $user->id],
            ['position_id' => $admPosition->id],
        );
    }
}
