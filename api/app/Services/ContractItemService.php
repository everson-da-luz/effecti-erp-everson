<?php

namespace App\Services;

use App\Models\ContractItem;
use App\Models\Service;

class ContractItemService
{
    public function store(array $data): array
    {
        try {
            if (!isset($data['unit_value']) || empty($data['unit_value'])) {
                $service = Service::find($data['service_id']);
                $data['unit_value'] = $service->base_monthly_value;
            }

            $data['unit_value'] = ContractItem::applyQuantityDiscount(
                $data['quantity'], 
                $data['unit_value'], 
                $data['discount_percent'] ?? 0
            );

            unset($data['discount_percent']);

            $item = ContractItem::create($data);

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Serviço adicionado ao contrato com sucesso.',
                'data' => $item->load('service')
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar adicionar o serviço no contrato.',
                'data' => []
            ];
        }
    }

    public function destroy(int $id): array
    {
        try {
            if (! ContractItem::destroy($id)) {
                throw new \Exception('Houve um erro ao tentar excluir o contrato.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Serviço removido do contrato.',
                'data' => [
                    'id' => $id
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => null
            ];
        }
    }
}