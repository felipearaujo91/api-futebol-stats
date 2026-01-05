<?php

namespace App\Adapters\ApiFootball;

use App\Contracts\OddsProviderInterface;
use App\DTO\OddsDTO;
use App\Services\ApiFootballClient;

class ApiFootballOddsAdapter extends ApiFootballClient implements OddsProviderInterface
{
    public function getOddsByFixture(int $fixtureId): OddsDTO
    {
        $data = $this->request('/odds', [
            'fixture' => $fixtureId,
            'bookmaker' => 8 // bet365
        ]);

        $bets = $data['response'][0]['bookmakers'][0]['bets'] ?? [];

        return new OddsDTO(
            vitoria_casa: null,
            empate: null,
            vitoria_fora: null,

            over_05_gols: null,
            over_15_gols: null,
            over_25_gols: null,
            over_35_gols: null,

            under_35_gols: null,
            under_25_gols: null,
            under_15_gols: null,
            under_05_gols: null,

            over_75_cantos: null,
            over_85_cantos: null,
            over_95_cantos: null,
            over_105_cantos: null,
            over_115_cantos: null,
            over_125_cantos: null,

            under_75_cantos: null,
            under_85_cantos: null,
            under_95_cantos: null,
            under_105_cantos: null,
            under_115_cantos: null,
            under_125_cantos: null,

            over_25_cartoes: null,
            over_35_cartoes: null,
            over_45_cartoes: null,

            under_25_cartoes: null,
            under_35_cartoes: null,
            under_45_cartoes: null
        );
    }
}
