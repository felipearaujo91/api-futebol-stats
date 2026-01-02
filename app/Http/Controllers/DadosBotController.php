<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MetadadosService;
use App\Services\OddsService;
use App\Services\ArbitragemService;
use App\Services\HistoricoH2HService;
use App\Services\TimeService;
use Illuminate\Http\JsonResponse;

class DadosBotController extends Controller
{
    public function __construct(
        protected MetadadosService $metadadosService,
        protected OddsService $oddsService,
        protected ArbitragemService $arbitragemService,
        protected HistoricoH2HService $historicoH2HService,
        protected TimeService $timeService,
    ) {}

    /**
     * Endpoint principal do bot
     * GET /api/dadosBot
     */
    public function index(): JsonResponse
    {
        // ⚠️ por enquanto IDs fixos
        $fixtureId = 1234;
        $timeCasaId = 33;
        $timeForaId = 48;

        $response = [
            'metadados' => $this->metadadosService->get($fixtureId),
            'odds_atuais' => $this->oddsService->get($fixtureId),
            'arbitragem' => $this->arbitragemService->get($fixtureId),
            'historico_h2h' => $this->historicoH2HService->get($timeCasaId, $timeForaId),
            'time_casa' => $this->timeService->getCasa($timeCasaId),
            'time_fora' => $this->timeService->getFora($timeForaId),
        ];

        return response()->json($response);
    }
}
