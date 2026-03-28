<?php

namespace App\Services;

use App\Models\Contract;

class ContractService
{
    public function getAllContracts()
    {
        try {
            $contracts = Contract::with('client', 'items.service')->get();

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $contracts
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar os contratos.',
                'data' => null
            ];
        }
    }

    public function getContractById(int $id): array
    {
        try {
            $contract = Contract::with('client', 'items.service')->find($id);

            if (! $contract) {
                return [
                    'success' => false,
                    'code' => 404,
                    'message' => 'Contrato não encontrado.',
                    'data' => []
                ];
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $contract
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar o contrato.',
                'data' => null
            ];
        }
    }

    public function store(array $data): array
    {
        try {
            $contract = Contract::create($data);

            if (!$contract) {
                throw new \Exception('Houve um erro ao tentar criar o contrato.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Contrato criado com sucesso.',
                'data' => $contract
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function update(array $data): array
    {
        try {
            $contract = Contract::find($data['id']);

            if (! $contract->update($data)) {
                throw new \Exception('Houve um erro ao tentar atualizar o contrato.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Contrato atualizado com sucesso.',
                'data' => $contract
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function destroy(int $id): array
    {
        try {
            if (! Contract::destroy($id)) {
                throw new \Exception('Houve um erro ao tentar excluir o contrato.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Contrato excluído com sucesso.',
                'data' => [
                    'id' => $id
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }
}