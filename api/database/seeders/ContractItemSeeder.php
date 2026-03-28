<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Service;
use App\Models\ContractItem;
use Illuminate\Database\Seeder;

class ContractItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contracts = Contract::all();
        $services = Service::all();

        if ($contracts->isEmpty() || $services->isEmpty()) {
            $this->command->info('Nenhum contrato ou serviço cadastrado.');
            return;
        }

        foreach ($contracts as $contract) {
            $numberOfItems = rand(1, 3);
            $randomServices = $services->random($numberOfItems);

            foreach ($randomServices as $service) {
                ContractItem::create([
                    'contract_id' => $contract->id,
                    'service_id' => $service->id,
                    'quantity' => rand(1, 5),
                    'unit_value' => $service->base_monthly_value
                ]);
            }
        }
    }
}
