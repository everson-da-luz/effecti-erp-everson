<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function __construct(protected ServiceService $serviceService) 
    {}

    public function index(): JsonResponse
    {
        $response = $this->serviceService->getAllServices();

        return response()->json($response, $response['code']);
    }

    public function show(int $id): JsonResponse
    {
        $response = $this->serviceService->getServiceById($id);

        return response()->json($response, $response['code']);
    }

    public function store(Request $request): JsonResponse
    {
        $dataPost = $request->post();
        $validator = Validator::make($dataPost, Service::rules('insert'), Service::errorMessage('insert'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataPost
            ], 422);
        }

        $response = $this->serviceService->store($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Service::rules('update', $id), Service::errorMessage('update', $id));

        if (empty($dataRequest) || $validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->serviceService->update($validator->getData());

        return response()->json($response, $response['code']);
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $dataRequest = $request->all();
        $dataRequest['id'] = $id;
        $validator = Validator::make($dataRequest, Service::rules('delete'), Service::errorMessage('delete'));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => $validator->errors()->all(),
                'data' => $dataRequest
            ], 422);
        }

        $response = $this->serviceService->destroy($id);

        return response()->json($response, $response['code']);
    }
}