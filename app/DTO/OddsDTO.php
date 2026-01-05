<?php

namespace App\DTO;

class OddsDTO
{
    public function __construct(
        public float $vitoria_casa,
        public float $empate,
        public float $vitoria_fora,

        // Gols
        public float $over_05_gols,
        public float $over_15_gols,
        public float $over_25_gols,
        public float $over_35_gols,

        public float $under_35_gols,
        public float $under_25_gols,
        public float $under_15_gols,
        public float $under_05_gols,

        // Escanteios
        public float $over_75_cantos,
        public float $over_85_cantos,
        public float $over_95_cantos,
        public float $over_105_cantos,
        public float $over_115_cantos,
        public float $over_125_cantos,

        public float $under_75_cantos,
        public float $under_85_cantos,
        public float $under_95_cantos,
        public float $under_105_cantos,
        public float $under_115_cantos,
        public float $under_125_cantos,

        // Cartões
        public float $over_25_cartoes,
        public float $over_35_cartoes,
        public float $over_45_cartoes,

        public float $under_25_cartoes,
        public float $under_35_cartoes,
        public float $under_45_cartoes,
    ) {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
