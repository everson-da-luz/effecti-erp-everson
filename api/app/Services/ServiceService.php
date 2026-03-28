<?php

namespace App\Services;

use App\Models\Service;

class ServiceService
{
    public function getAllServices()
    {
        try {
            $services = Service::all();

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $services
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar os serviços.',
                'data' => null
            ];
        }
    }

    public function getServiceById(int $id): array
    {
        try {
            $service = Service::find($id);

            if (! $service) {
                return [
                    'success' => false,
                    'code' => 404,
                    'message' => 'Serviço não encontrado.',
                    'data' => []
                ];
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $service
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar o serviço.',
                'data' => null
            ];
        }
    }

    public function store(array $data): array
    {
        try {
            $service = Service::create($data);

            if (! $service) {
                throw new \Exception('Houve um erro ao tentar criar o serviço.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Serviço criado com sucesso.',
                'data' => $service
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
            $service = Service::find($data['id']);

            if (! $service->update($data)) {
                throw new \Exception('Houve um erro ao tentar atualizar o serviço.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Serviço atualizado com sucesso.',
                'data' => $service
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
            if (! Service::destroy($id)) {
                throw new \Exception('Houve um erro ao tentar excluir o serviço.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Serviço excluido com sucesso.',
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