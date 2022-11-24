<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::create([
            "name" => \Str::random(5),
            "email" => \Str::random(7). "@gmail.com",
            "password" =>\Hash::make("12345"),
         ]);
    }
}
