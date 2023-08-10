<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

            User::create([
                'first_name' => 'ram',
                'last_name' => 'patel',
                'email' => 'admin@gmail.com',
                'password' => hash::make('admin@123'),
                'image' => null,
                'role' => 'admin',
                'token' => \Illuminate\Support\Str::random(60),
            ]);
    }
}
