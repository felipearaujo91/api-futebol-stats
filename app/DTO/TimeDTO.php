<?php

namespace App\DTO;

class TimeDTO
{
    public function __construct(
        public string $nome,
        public int $posicao_tabela,
        public ?array $forma_recente_geral,
        public array $ultimos_jogos,
        public EstatisticasTimeDTO $stats_season,
        public array $noticias_e_desfalques,
        public string $fator_motivacional
    ) {}

    public function toArrayCasa(): array
    {
        return [
            'nome' => $this->nome,
            'posicao_tabela' => $this->posicao_tabela,
            'forma_recente_geral' => $this->forma_recente_geral,
            'ultimos_jogos_casa' => $this->ultimos_jogos,
            'stats_season' => $this->stats_season->toArray(),
            'noticias_e_desfalques' => array_map(fn ($d) => $d->toArray(), $this->noticias_e_desfalques),
            'fator_motivacional' => $this->fator_motivacional,
        ];
    }

    public function toArrayFora(): array
    {
        return [
            'nome' => $this->nome,
            'posicao_tabela' => $this->posicao_tabela,
            'forma_recente_geral' => $this->forma_recente_geral,
            'ultimos_jogos_fora' => $this->ultimos_jogos,
            'stats_season' => $this->stats_season->toArray(),
            'noticias_e_desfalques' => array_map(fn ($d) => $d->toArray(), $this->noticias_e_desfalques),
            'fator_motivacional' => $this->fator_motivacional,
        ];
    }
}
