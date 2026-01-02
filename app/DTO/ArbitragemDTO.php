<?php

namespace App\DTO;

class ArbitragemDTO
{
    public function __construct(
        public string $nome,
        public ?float $media_cartoes_amarelos,
        public ?float $media_cartoes_vermelhos,
        public ?float $media_faltas_por_jogo,
        public ?string $caracteristica,
    ) {}
}
