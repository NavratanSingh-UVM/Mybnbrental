<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $role=Role::create([
        //     'name'=>'super-admin',
        // ]);

        $user = User::create([
            'name'=>"My BNB Rentals",
            'email'=>"bookings@mybnbrentals.com",
            'password'=>Hash::make('Mybnbrentals@123#'),
            'show_password'=>"Mybnbrentals@123#"
        ]);

        $user->assignRole("super-admin");
    }
}
