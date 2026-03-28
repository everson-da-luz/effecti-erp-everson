<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Client::create([
                'name' => fake()->name(),
                'document' => fake()->unique()->numerify('###########'),
                'email' => fake()->unique()->safeEmail(),
                'status' => fake()->randomElement(['Ativo', 'Inativo']),
            ]);
        }
    }
}