<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{
    public function __construct(protected ContractService $contractService) 
    {}

    public function index(): JsonResponse
    {
        $response = $this->contractService->getAllContracts();

        return response()->json($response, $response['code']);
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->contractService->getContractById($id);

        return response()->json($response, $response['code']);
    }

    public function store(Request $request): JsonResponse
    {
        $dataPost = $request->post();
        $validator = Validator::make($dataPost, Contract::rules('insert'), Contract::errorMessage('insert'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataPost
            ], 422);
        }

        $response = $this->contractService->store($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Contract::rules('update', $id), Contract::errorMessage('update', $id));

        if (empty($dataRequest) || $validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->contractService->update($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Contract::rules('delete'), Contract::errorMessage('delete'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->contractService->destroy($id);

        return response()->json($response, $response['code']);
    }
}