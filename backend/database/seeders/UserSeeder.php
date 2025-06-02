<?php

namespace Database\Seeders;

use App\Models\User;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(30)->create();

        DB::table('users')->insert([
            "role" => "admin",
            "name" => "Admin",
            "password" => Hash::make("Admin123456"),
            "email" => "admin@test.com",
            "phone" => "0679873562",
            "country" => "Hungary",
            "city" => "Budapest",
            "zip" => "1163",
            "street_name" => "Petőfi",
            "street_type" => "utca",
            "street_number" => "11",
            "floor" => "Nincs"
        ]);

        $this->command->info("A felhasználók szinkronizációja sikeresen megtörtént!");
    }
}
