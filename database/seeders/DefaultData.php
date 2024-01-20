<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUsers();
    }
    public function createUsers()
    {
        $userArr = [
            'admin@gmail.com'
        ];
        foreach ($userArr as $email) {
            $user = User::query()->firstOrCreate(['email' => $email], [
                'name'     => $email,
                'username'     => $email,
                'status'   => User::STATUS_ACTIVE,
                'password' => Hash::make('admin')
            ]);
            $user->syncRoles([User::ROLE_ADMIN]);
        }
    }
}
