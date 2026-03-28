<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function __construct(protected ClientService $clientService) 
    {}

    public function index(): JsonResponse
    {
        $response = $this->clientService->getAllClients();

        return response()->json($response, $response['code']);
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->clientService->getClientById($id);

        return response()->json($response, $response['code']);
    }

    public function store(Request $request): JsonResponse
    {
        $dataPost = $request->post();
        $validator = Validator::make($dataPost, Client::rules('insert'), Client::errorMessage('insert'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataPost
            ], 422);
        }

        $response = $this->clientService->store($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Client::rules('update', $id), Client::errorMessage('update', $id));

        if (empty($dataRequest) || $validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->clientService->update($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Client::rules('delete'), Client::errorMessage('delete'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->clientService->destroy($id);

        return response()->json($response, $response['code']);
    }
}