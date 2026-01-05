<?php

namespace App\Adapters\Mock;

use App\Contracts\TimeProviderInterface;

class MockTimeAdapter implements TimeProviderInterface
{
    public function getTimeCasa(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {
        return [
            'nome' => $nome,
            'posicao_tabela' => 3,
            'forma_recente_geral' => ['V', 'E', 'V', 'D', 'V'],
            'ultimos_jogos' => ['V (2-1)', 'E (1-1)'],
            'stats_season' => [],
            'noticias_e_desfalques' => [],
            'fator_motivacional' => ''
        ];
    }

    public function getTimeFora(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {
        return [
            'nome' => $nome,
            'posicao_tabela' => 8,
            'forma_recente_geral' => ['D', 'E', 'V', 'D', 'E'],
            'ultimos_jogos' => ['D (0-1)', 'E (0-0)'],
            'stats_season' => [],
            'noticias_e_desfalques' => [],
            'fator_motivacional' => ''
        ];
    }
}
