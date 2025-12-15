<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada data locations
        $locations = Location::all();

        if ($locations->isEmpty()) {
            // Buat data locations jika kosong
            $locations = Location::factory()->count(5)->create();
        }

        $users = [
            [
                'nama' => 'Admin User',
                'telepon' => '081234567890',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[0]->id,
                'alamat' => 'Jl. Admin No. 1, RT 01/RW 01',
            ],
            [
                'nama' => 'Maya Sari',
                'telepon' => '085678901234',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[4]->id,
                'alamat' => 'Jl. Anggrek No. 89, RT 05/RW 04',
            ],
            [
                'nama' => 'Eni Erawati',
                'telepon' => '085229297152',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[5]->id,
            ],
            [
                'nama' => 'Vicky',
                'telepon' => '082223190195',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[5]->id,
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Default password for all users: password123');
    }
}
