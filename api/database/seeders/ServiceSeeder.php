<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Hospedagem Cloud Premium', 'base_monthly_value' => 250.00],
            ['name' => 'Manutenção de Sistema', 'base_monthly_value' => 1500.00],
            ['name' => 'Consultoria Técnica (Hora)', 'base_monthly_value' => 180.00],
            ['name' => 'Licença ERP Mensal', 'base_monthly_value' => 490.90],
            ['name' => 'Backup Gerenciado', 'base_monthly_value' => 85.00],
            ['name' => 'Suporte 24/7', 'base_monthly_value' => 1200.00],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
