<?php

namespace App\DTO;

class MetadadosDTO
{
    public function __construct(
        public string $jogo,
        public string $campeonato,
        public string $data_hora,
        public string $estadio,
        public string $clima_previsto,
        public string $importancia_jogo,
    ) {}
}
