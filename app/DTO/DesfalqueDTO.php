<?php

namespace App\DTO;

class DesfalqueDTO
{
    public function __construct(
        public string $noticia_ou_desfalque,
        public string $atleta,
        public string $posicao,
        public string $motivo,
        public int $Partidas,
        public int $partidas_titular,
        public int $total_minutos_jogados,
        public float $nota_media,
        public ?float $gols_sofridos_por_jogo, // nullable (nem todo jogador tem)
        public ?int $gols,
        public ?float $gols_esperados,
        public ?int $assistencias,
        public int $cartoes_amarelo,
        public int $cartoes_vermelho,
        public ?int $jogos_sem_sofrer_gol
    ) {}

    public function toArray(): array
    {
        return array_filter(
            get_object_vars($this),
            fn ($v) => $v !== null
        );
    }
}
