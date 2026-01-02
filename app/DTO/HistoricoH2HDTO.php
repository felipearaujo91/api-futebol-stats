<?php

namespace App\DTO;

class HistoricoH2HDTO
{
    public function __construct(
        public string $data,
        public string $competicao,
        public string $mandante,
        public string $placar,
        public string $resumo,
    ) {}
}
