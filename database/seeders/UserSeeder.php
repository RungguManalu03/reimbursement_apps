<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => Str::uuid(),
                'nip' => 1234,
                'nama' => 'DONI',
                'jabatan' => 'DIREKTUR',
                'password' => Hash::make('123456')
            ],
            [
                'id' => Str::uuid(),
                'nip' => 1235,
                'nama' => 'DONO',
                'jabatan' => 'FINANCE',
                'password' => Hash::make('123456')
            ],
            [
                'id' => Str::uuid(),
                'nip' => 1236,
                'nama' => 'DONA',
                'jabatan' => 'STAFF',
                'password' => Hash::make('123456')
            ],
        ];

        foreach ($users as $user) {
            User::query()->create($user);
        }
    }
}
