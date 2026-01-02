<?php

namespace App\Services;

use App\DTO\MetadadosDTO;

class MetadadosService
{
    public function get(): MetadadosDTO
    {
        return new MetadadosDTO(
            jogo: 'Manchester United vs West Ham United',
            campeonato: 'Premier League - Rodada 14',
            data_hora: '2025-12-04 17:00:00',
            estadio: 'Old Trafford',
            clima_previsto: 'Chuva fraca, 5°C',
            importancia_jogo: 'Jogo decisivo para ambas as equipes'
        );
    }
}
