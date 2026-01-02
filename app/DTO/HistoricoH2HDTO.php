<?php

namespace App\DTO;

class HistoricoH2HDTO
{
    public function __construct(
        public string $data,
        public string $competicao,
        public string $mandante,
        public string $placar,
        public ?string $resumo,
    ) {}

    public function toArray(): array
    {
        return array_filter(
            get_object_vars($this),
            fn ($v) => $v !== null
        );
    }
}
