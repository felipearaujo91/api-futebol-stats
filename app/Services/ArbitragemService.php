<?php

namespace App\Services;

use App\DTO\ArbitragemDTO;
use App\Services\ApiFootballClient;

class ArbitragemService extends ApiFootballClient
{
    /**
     * Retorna os dados da arbitragem de uma partida
    */
    public function get(int $fixtureId): ArbitragemDTO
    {
        $data = $this->request('/fixtures', [
            'id' => $fixtureId
        ]);

        $fixture = $data['response'][0] ?? [];

        return new ArbitragemDTO(
            nome: $fixture['fixture']['referee'] ?? 'Desconhecido',
            media_cartoes_amarelos: null,  // não disponível na API
            media_cartoes_vermelhos: null, // não disponível na API
            media_faltas_por_jogo: null,   // não disponível na API
            caracteristica: null            // você pode preencher com lógica própria se quiser
        );
    }
}
