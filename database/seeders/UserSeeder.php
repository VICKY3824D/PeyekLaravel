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
                'nama' => 'Eni Erawati',
                'telepon' => '081234567890',
                'password' => Hash::make('eni123'),
                'id_lokasi' => $locations[0]->id,
                'alamat' => 'Terbis, RT 02/RW 01',
            ],
            [
                'nama' => 'Vicky',
                'telepon' => '082223190195',
                'password' => Hash::make('vicky123'),
                'id_lokasi' => $locations[1]->id,
                'alamat' => 'Jl. Merdeka No. 123, RT 02/RW 05',
            ],
            [
                'nama' => 'Azriel',
                'telepon' => '083456789012',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[2]->id,
                'alamat' => 'Jl. Melati No. 45, RT 03/RW 02',
            ],
            [
                'nama' => 'Maya Sari',
                'telepon' => '085678901234',
                'password' => Hash::make('password123'),
                'id_lokasi' => $locations[4]->id,
                'alamat' => 'Jl. Anggrek No. 89, RT 05/RW 04',
            ]
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Default password for all users: password123');
    }
}
