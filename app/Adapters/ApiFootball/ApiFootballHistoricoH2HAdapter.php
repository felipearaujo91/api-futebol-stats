<?php

namespace App\Adapters\ApiFootball;

use App\Contracts\HistoricoH2HProviderInterface;
use App\Services\ApiFootballClient;

class ApiFootballHistoricoH2HAdapter
    extends ApiFootballClient
    implements HistoricoH2HProviderInterface
{
    public function getH2H(
        int $timeCasaId,
        int $timeForaId,
        int $limite = 5
    ): array {
        $data = $this->request('/fixtures/headtohead', [
            'h2h' => "{$timeCasaId}-{$timeForaId}",
        ]);

        $fixtures = $data['response'] ?? [];

        // Ordena por data (mais recente primeiro)
        usort($fixtures, fn ($a, $b) =>
            strtotime($b['fixture']['date']) <=> strtotime($a['fixture']['date'])
        );

        $fixtures = array_slice($fixtures, 0, $limite);

        return array_map(function ($f) {
            return [
                'data' => $f['fixture']['date'],
                'competicao' => $f['league']['name'] ?? null,
                'mandante' => $f['teams']['home']['name'] ?? null,
                'placar' =>
                    ($f['goals']['home'] ?? '?')
                    . '-'
                    . ($f['goals']['away'] ?? '?'),
                'resumo' => null,
            ];
        }, $fixtures);
    }
}
