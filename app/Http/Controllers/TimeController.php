<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TimeService;
use Illuminate\Http\JsonResponse;

class TimeController extends Controller
{
    public function __construct(
        protected TimeService $timeService
    ) {}

    /**
     * Retorna informações de um time pelo ID
     * @param int $idTime
    */
    public function show(int $idTime): JsonResponse
    {
        $response = $this->timeService->findById($idTime);

        return response()->json([
            'success' => true,
            'data' => $response['response'][0] ?? null
        ]);
    }
}
