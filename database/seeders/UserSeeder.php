<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => 'Masum Billah',
                'email' => 'billah@gmail.com',
                'password' => bcrypt('12345678'),

            ]);
            $user->roles()->create([
                'name' => UserRole::ROLE_USER,
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }


}

