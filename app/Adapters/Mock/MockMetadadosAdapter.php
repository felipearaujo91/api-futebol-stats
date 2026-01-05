<?php

namespace App\Adapters\Mock;

use App\Contracts\MetadadosProviderInterface;

class MockMetadadosAdapter implements MetadadosProviderInterface
{
    public function getFixtureById(int $fixtureId): array
    {
        return [
            'jogo' => 'Manchester United vs West Ham United',
            'campeonato' => 'Premier League - Regular Season - 14',
            'data_hora' => '2025-12-04T17:00:00+00:00',
            'estadio' => 'Old Trafford',
            'timeCasaId' => 33,
            'timeCasaNome' => 'Manchester United',
            'timeForaId' => 48,
            'timeForaNome' => 'West Ham United',
            'ligaId' => 39,
        ];
    }
}
