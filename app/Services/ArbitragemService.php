<?php

namespace App\Services;

use App\DTO\ArbitragemDTO;

class ArbitragemService
{
    public function get(): ArbitragemDTO
    {
        return new ArbitragemDTO(
            nome: 'Andrew Kitchen',
            media_cartoes_amarelos: 2.5,
            media_cartoes_vermelhos: 0.1,
            media_faltas_por_jogo: 14.1,
            caracteristica: 'Estilo equilibrado, prioriza o diálogo'
        );
    }
}
