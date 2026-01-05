<?php

namespace App\Adapters\ApiFootball;

use App\Contracts\MetadadosProviderInterface;
use App\Services\ApiFootballClient;

class ApiFootballMetadadosAdapter extends ApiFootballClient implements MetadadosProviderInterface
{
    public function getFixtureById(int $fixtureId): array
    {
        $data = $this->request('/fixtures', [
            'id' => $fixtureId
        ]);

        $fixture = $data['response'][0] ?? null;

        if (!$fixture) {
            throw new \RuntimeException('Fixture ' . $fixtureId . ' não encontrado');
        }

        return [
            'jogo' => $fixture['teams']['home']['name'] . ' vs ' . $fixture['teams']['away']['name'],

            'campeonato' => $fixture['league']['name']
                . ' - '
                . $fixture['league']['round'],

            'data_hora' => $fixture['fixture']['date'],

            'estadio' => $fixture['fixture']['venue']['name'] ?? null,

            'timeCasaId' => $fixture['teams']['home']['id'],
            'timeCasaNome' => $fixture['teams']['home']['name'],

            'timeForaId' => $fixture['teams']['away']['id'],
            'timeForaNome' => $fixture['teams']['away']['name'],

            'ligaId' => $fixture['league']['id'],
        ];
    }
}
