<?php

namespace App\Services;

use App\Contracts\MetadadosProviderInterface;
use App\DTO\MetadadosDTO;
use Carbon\Carbon;

class MetadadosService
{
    public function __construct(
        private MetadadosProviderInterface $provider
    ) {}

    public function get(int $fixtureId): MetadadosDTO
    {
        $fixture = $this->provider->getFixtureById($fixtureId);

        return new MetadadosDTO(
            jogo: $fixture['jogo'],
            campeonato: $fixture['campeonato'],
            data_hora: Carbon::parse($fixture['data_hora'])->format('Y-m-d H:i:s'),
            estadio: $fixture['estadio'],
            timeCasaId: $fixture['timeCasaId'],
            timeCasaNome: $fixture['timeCasaNome'],
            timeForaId: $fixture['timeForaId'],
            timeForaNome: $fixture['timeForaNome'],
            ligaId: $fixture['ligaId'],

            // não disponível na API, ver como vai fazer
            clima_previsto: null,
            importancia_jogo: null
        );
    }
}
