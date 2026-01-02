<?php

namespace App\DTO;

class EstatisticasTimeDTO
{
    public function __construct(
        public int $partidas,
        public int $vitorias,
        public int $empates,
        public int $derrotas,
        public int $gols_pro,
        public int $gols_sofridos,
        public float $media_gols_pro,
        public float $media_gols_sofridos,
        public float $media_escanteios_favor,
        public float $media_cruzamentos_pg,
        public float $media_chutes_no_gol,
        public float $media_cartoes_recebidos,
        public float $posse_bola_media,
    ) {}

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
