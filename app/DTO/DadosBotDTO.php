<?php

namespace App\DTO;

class DadosBotDTO
{
    public function __construct(
        public MetadadosDTO $metadados,
        public OddsDTO $oddsAtuais,
        public ArbitragemDTO $arbitragem,
        public array $historicoH2H,
        public TimeDTO $timeCasa,
        public TimeDTO $timeFora,
    ) {}
}
