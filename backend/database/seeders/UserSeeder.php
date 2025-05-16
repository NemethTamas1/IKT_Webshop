<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(30)->create();

        $this->command->info("A felhasználók szinkronizációja sikeresen megtörtént!");
    }
}
