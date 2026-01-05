<?php

namespace App\Adapters\ApiFootball;

use App\Contracts\ArbitragemProviderInterface;
use App\DTO\ArbitragemDTO;
use App\Services\ApiFootballClient;

class ApiFootballArbitragemAdapter extends ApiFootballClient implements ArbitragemProviderInterface
{
    public function getByFixture(int $fixtureId): ArbitragemDTO
    {
        $data = $this->request('/fixtures', [
            'id' => $fixtureId
        ]);

        $fixture = $data['response'][0] ?? [];

        return new ArbitragemDTO(
            nome: $fixture['fixture']['referee'] ?? 'Desconhecido',
            media_cartoes_amarelos: null,  // API não fornece
            media_cartoes_vermelhos: null, // API não fornece
            media_faltas_por_jogo: null,   // API não fornece
            caracteristica: null         
        );
    }
}
