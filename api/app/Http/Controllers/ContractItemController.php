<?php

namespace App\Http\Controllers;

use App\Models\ContractItem;
use App\Services\ContractItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContractItemController extends Controller
{
    public function __construct(protected ContractItemService $contractItemService) 
    {}

    public function store(Request $request, int $contractId): JsonResponse
    {
        $dataPost = $request->all();
        $dataPost['contract_id'] = $contractId;
        $validator = Validator::make($dataPost, ContractItem::rules('insert'), ContractItem::errorMessage('insert'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataPost
            ], 422);
        }

        $response = $this->contractItemService->store($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, ContractItem::rules('delete'), ContractItem::errorMessage('delete'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->contractItemService->destroy($id);

        return response()->json($response, $response['code']);
    }
}