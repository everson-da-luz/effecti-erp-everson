<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Contract;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientIds = Client::pluck('id')->toArray();

        if (empty($clientIds)) {
            $this->command->info('Nenhum cliente cadastrado.');
            return;
        }

        for ($i = 0; $i < 15; $i++) {
            $startDate = Carbon::now()->subMonths(rand(1, 12));
            
            Contract::create([
                'client_id' => $clientIds[array_rand($clientIds)],
                'start_date' => $startDate->format('Y-m-d'),
                'end_date'  => $startDate->copy()->addYear()->format('Y-m-d'),
                'status' => fake()->randomElement(['Ativo', 'Cancelado'])
            ]);
        }
    }
}
