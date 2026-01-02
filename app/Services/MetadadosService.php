<?php

namespace App\Services;

use App\DTO\MetadadosDTO;
use App\Services\ApiFootballClient;
use Carbon\Carbon;

class MetadadosService
{
    public function __construct(
        protected ApiFootballClient $apiFootball
    ) {}

    public function get(int $fixtureId): MetadadosDTO
    {
        $response = $this->apiFootball->request('/fixtures', [
            'id' => $fixtureId
        ]);

        $fixture = $response['response'][0] ?? null;

        if (!$fixture) {
            throw new \Exception('Fixture não encontrado');
        }

        return new MetadadosDTO(
            jogo: $fixture['teams']['home']['name']
                . ' vs '
                . $fixture['teams']['away']['name'],

            campeonato: $fixture['league']['name']
                . ' - '
                . $fixture['league']['round'],

            data_hora: Carbon::parse($fixture['fixture']['date'])->format('Y-m-d H:i:s'),

            estadio: $fixture['fixture']['venue']['name'] ?? null,

            // clima não é garantido
            clima_previsto: $fixture['fixture']['weather']['description'] ?? null,

            // precisa definir como vai ficar
            importancia_jogo: null,

            timeCasaId: $fixture['teams']['home']['id'],
            timeForaId: $fixture['teams']['away']['id'],
        );
    }
}
