<?php

namespace App\Services;

use App\DTO\TimeDTO;
use App\DTO\EstatisticasTimeDTO;
use App\DTO\DesfalqueDTO;

class TimeService
{
    public function getCasa(): array
    {
        $dto = new TimeDTO(
            nome: 'Manchester United',
            posicao_tabela: 9,
            forma_recente: ['V', 'E', 'E', 'D', 'V'],
            ultimos_jogos: ['V (4-2)', 'V (2-0)'],
            stats_season: new EstatisticasTimeDTO(
                13, 6, 3, 4,
                21, 20,
                1.61, 1.53,
                4.2,
                12.4,
                10.2,
                2.4,
                52.5
            ),
            noticias_e_desfalques: [
                new DesfalqueDTO(
                    noticia_ou_desfalque: 'desfalque',
                    atleta: 'Harry Maguire',
                    posicao: 'Zagueiro',
                    motivo: 'Lesão',
                    Partidas: 14,
                    partidas_titular: 13,
                    total_minutos_jogados: 1161,
                    nota_media: 7.08,
                    gols_sofridos_por_jogo: null,
                    gols: 1,
                    gols_esperados: 0.35,
                    assistencias: 0,
                    cartoes_amarelo: 3,
                    cartoes_vermelho: 0,
                    jogos_sem_sofrer_gol: null
                ),
                
                new DesfalqueDTO(
                    noticia_ou_desfalque: 'desfalque',
                    atleta: 'Lucas Paquetá',
                    posicao: 'Meio campista',
                    motivo: 'Suspensão',
                    Partidas: 12,
                    partidas_titular: 12,
                    total_minutos_jogados: 1044,
                    nota_media: 7.08,
                    gols_sofridos_por_jogo: null,
                    gols: 3,
                    gols_esperados: 1.85,
                    assistencias: 0,
                    cartoes_amarelo: 5,
                    cartoes_vermelho: 1,
                    jogos_sem_sofrer_gol: null
                ),

                new DesfalqueDTO(
                    noticia_ou_desfalque: 'desfalque',
                    atleta: 'Crysencio Summerville',
                    posicao: 'Extremo',
                    motivo: 'Lesão',
                    Partidas: 9,
                    partidas_titular: 8,
                    total_minutos_jogados: 645,
                    nota_media: 6.8,
                    gols_sofridos_por_jogo: null,
                    gols: 0,
                    gols_esperados: 0.91,
                    assistencias: 1,
                    cartoes_amarelo: 3,
                    cartoes_vermelho: 0,
                    jogos_sem_sofrer_gol: null
                )


            ],
            fator_motivacional: 'Busca vaga em competição europeia'
        );

        return $dto->toArrayCasa();
    }

    public function getFora(): array
    {
        $dto = new TimeDTO(
            nome: 'West Ham United',
            posicao_tabela: 18,
            forma_recente: ['D', 'V', 'V', 'E', 'D'],
            ultimos_jogos: ['E (2-2)', 'D (2-1)'],
            stats_season: new EstatisticasTimeDTO(
                13, 3, 2, 8,
                15, 27,
                1.15, 2.07,
                5.5,
                12.4,
                10.2,
                2.4,
                43.2
            ),
            noticias_e_desfalques: [
                new DesfalqueDTO(
                    noticia_ou_desfalque: 'desfalque',
                    atleta: 'Lucas Paquetá',
                    posicao: 'Meio campista',
                    motivo: 'Suspensão',
                    Partidas: 12,
                    partidas_titular: 12,
                    total_minutos_jogados: 1044,
                    nota_media: 7.08,
                    gols_sofridos_por_jogo: null,
                    gols: 3,
                    gols_esperados: 1.85,
                    assistencias: 0,
                    cartoes_amarelo: 5,
                    cartoes_vermelho: 1,
                    jogos_sem_sofrer_gol: null
                )
            ],
            fator_motivacional: 'Luta contra o rebaixamento'
        );

        return $dto->toArrayFora();
    }
}
