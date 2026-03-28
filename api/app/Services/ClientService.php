<?php

namespace App\Services;

use App\Models\Client;

class ClientService
{
    public function getAllClients()
    {
        try {
            $clients = Client::all();

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $clients
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar os clientes.',
                'data' => null
            ];
        }
    }

    public function getClientById(int $id): array
    {
        try {
            $client = Client::find($id);

            if (! $client) {
                return [
                    'success' => false,
                    'code' => 404,
                    'message' => 'Cliente não encontrado.',
                    'data' => []
                ];
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => '',
                'data' => $client
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Houve um erro interno ao tentar buscar o cliente.',
                'data' => null
            ];
        }
    }

    public function store(array $data): array
    {
        try {
            $client = Client::create($data);

            if (! $client) {
                throw new \Exception('Houve um erro ao tentar criar o cliente.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Cliente criado com sucesso.',
                'data' => $client
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
            $client = Client::find($data['id']);

            if (! $client->update($data)) {
                throw new \Exception('Houve um erro ao tentar atualizar o cliente.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Cliente atualizado com sucesso.',
                'data' => $client
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
            if (! Client::destroy($id)) {
                throw new \Exception('Houve um erro ao tentar excluir o cliente.');
            }

            return [
                'success' => true,
                'code' => 200,
                'message' => 'Cliente excluido com sucesso.',
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