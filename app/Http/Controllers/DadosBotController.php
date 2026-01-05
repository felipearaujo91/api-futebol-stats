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
     * GET /api/dados-bot
     */
    public function index(): JsonResponse
    {
        
        $fixtureId = 1215846;
        $metadados = $this->metadadosService->get($fixtureId);
        $timeCasaId = $metadados->timeCasaId;
        $timeForaId = $metadados->timeForaId;
        $temporadaAno = 2024;

        $response = [
            'metadados' => $metadados,
            'odds_atuais' => $this->oddsService->get($fixtureId),
            'arbitragem' => $this->arbitragemService->get($fixtureId),
            'historico_h2h' => $this->historicoH2HService->get($timeCasaId, $timeForaId),
            'time_casa' => $this->timeService->getCasa($timeCasaId, $metadados->ligaId, $temporadaAno, $fixtureId, $metadados->timeCasaNome),
            'time_fora' => $this->timeService->getFora($timeForaId, $metadados->ligaId, $temporadaAno, $fixtureId, $metadados->timeForaNome),
        ];

        return response()->json($response);
    }
}
