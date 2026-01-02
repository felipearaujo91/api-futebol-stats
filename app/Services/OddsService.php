<?php

namespace App\Services;

use App\DTO\OddsDTO;

class OddsService
{
    public function get(int $fixtureId): OddsDTO
    {
        return new OddsDTO(
            vitoria_casa: 1.42,
            empate: 5.00,
            vitoria_fora: 7.00,

            over_05_gols: 1.03,
            over_15_gols: 1.15,
            over_25_gols: 1.53,
            over_35_gols: 2.30,

            under_35_gols: 1.57,
            under_25_gols: 2.37,
            under_15_gols: 4.75,
            under_05_gols: 14.50,

            over_75_cantos: 1.16,
            over_85_cantos: 1.31,
            over_95_cantos: 1.57,
            over_105_cantos: 1.95,
            over_115_cantos: 2.60,
            over_125_cantos: 3.60,

            under_75_cantos: 4.75,
            under_85_cantos: 3.10,
            under_95_cantos: 2.25,
            under_105_cantos: 1.73,
            under_115_cantos: 2.43,
            under_125_cantos: 3.25,

            over_25_cartoes: 1.41,
            over_35_cartoes: 2.00,
            over_45_cartoes: 3.20,

            under_25_cartoes: 2.65,
            under_35_cartoes: 1.71,
            under_45_cartoes: 1.30,
        );
    }
}
