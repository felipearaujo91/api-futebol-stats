<?php

namespace App\Adapters\Mock;

use App\Contracts\ArbitragemProviderInterface;
use App\DTO\ArbitragemDTO;

class MockArbitragemAdapter implements ArbitragemProviderInterface
{
    public function getByFixture(int $fixtureId): ArbitragemDTO
    {
        return new ArbitragemDTO(
            nome: 'João da Silva',
            media_cartoes_amarelos: 4.8,
            media_cartoes_vermelhos: 0.35,
            media_faltas_por_jogo: 28,
            caracteristica: 'Árbitro rigoroso, distribui muitos cartões'
        );
    }
}
