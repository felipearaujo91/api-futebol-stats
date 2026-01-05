<?php

namespace App\Adapters\Mock;

use App\Contracts\HistoricoH2HProviderInterface;

class MockHistoricoH2HAdapter implements HistoricoH2HProviderInterface
{
    public function getH2H(
        int $timeCasaId,
        int $timeForaId,
        ?int $limite = 5
    ): array {
        $mock = [
            [
                'data' => '2025-05-11T15:00:00+00:00',
                'competicao' => 'Premier League',
                'mandante' => 'Manchester United',
                'placar' => '0-2',
                'resumo' => 'United criou mais chances, mas sofreu gols em contra-ataques.'
            ],
            [
                'data' => '2024-12-23T18:30:00+00:00',
                'competicao' => 'Premier League',
                'mandante' => 'West Ham United',
                'placar' => '1-1',
                'resumo' => 'Jogo equilibrado, posse dividida e poucas chances claras.'
            ],
            [
                'data' => '2024-05-07T16:00:00+00:00',
                'competicao' => 'Premier League',
                'mandante' => 'Manchester United',
                'placar' => '3-1',
                'resumo' => 'United dominante em casa, pressão alta e controle do jogo.'
            ],
            [
                'data' => '2023-11-04T17:00:00+00:00',
                'competicao' => 'Premier League',
                'mandante' => 'West Ham United',
                'placar' => '2-0',
                'resumo' => 'West Ham eficiente defensivamente e letal nos contra-ataques.'
            ],
            [
                'data' => '2023-04-30T14:00:00+00:00',
                'competicao' => 'Premier League',
                'mandante' => 'Manchester United',
                'placar' => '1-0',
                'resumo' => 'Partida truncada, decidida em bola parada.'
            ],
        ];

        return array_slice($mock, 0, $limite);
    }
}
