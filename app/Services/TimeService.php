<?php

namespace App\Services;

use App\DTO\TimeDTO;
use App\DTO\EstatisticasTimeDTO;
use App\DTO\DesfalqueDTO;

class TimeService extends ApiFootballClient
{

    public int $ligaId;
    public int $temporadaAno;
    public string $timeCasaNome;
    public string $timeForaNome;
    public int $fixtureId;

    /**
     * Busca dados do time da casa
     */
    public function getCasa(int $timeId): array
    {
        return $this->buildTime($timeId, 'casa');
    }

    /**
     * Busca dados do time visitante
     */
    public function getFora(int $timeId): array
    {
        return $this->buildTime($timeId, 'fora');
    }

    /**
     * Monta DTO do time a partir da API
     */
    private function buildTime(int $timeId, string $tipo): array
    {
        $timeNome = '';
        if($tipo === 'casa') {
            $timeNome = $this->timeCasaNome;
        } else {
            $timeNome = $this->timeForaNome;
        }


        $statsData = $this->request('/teams/statistics', [
            'team' => $timeId,
            'season' => $this->temporadaAno,
            'league' => $this->ligaId
            // 'last' => 5
        ]);

        $stats = $statsData['response'] ?? [];
        
        $estatisticas = new EstatisticasTimeDTO(
            partidas: $stats['fixtures']['played']['total'] ?? 0,
            vitorias: $stats['fixtures']['wins']['total'] ?? 0,
            empates: $stats['fixtures']['draws']['total'] ?? 0,
            derrotas: $stats['fixtures']['loses']['total'] ?? 0,
            gols_pro: $stats['goals']['for']['total']['total'] ?? 0,
            gols_sofridos: $stats['goals']['against']['total']['total'] ?? 0,
            media_gols_pro: $stats['goals']['for']['average']['total'] ?? 0,
            media_gols_sofridos: $stats['goals']['against']['average']['total'] ?? 0,
            media_escanteios_favor: 0,
            media_cruzamentos_pg: 0,
            media_chutes_no_gol: 0,
            media_cartoes_recebidos: ($this->somarCartoes($stats['cards'], 'yellow') + $this->somarCartoes($stats['cards'], 'red')) / $stats['fixtures']['played']['total'],
            posse_bola_media: 0
        );

        
        $lastFixtures = $this->request('/fixtures', [
            'team' => $timeId,
            'season' => $this->temporadaAno
        ]);

        $ultimosJogos = array_map(function($f) use ($timeId) {
            $mandante = $f['teams']['home']['id'] === $timeId;
            $placar = ($f['goals']['home'] ?? '?') . '-' . ($f['goals']['away'] ?? '?');
            $resultado = $mandante
                ? $this->getResultado($f['goals']['home'] ?? 0, $f['goals']['away'] ?? 0)
                : $this->getResultado($f['goals']['away'] ?? 0, $f['goals']['home'] ?? 0);
            return "{$resultado} ({$placar})";
        }, $lastFixtures['response'] ?? []);

        
        $playersData = $this->request('/injuries', [
            'team' => $timeId,
            'season' => $this->temporadaAno,
            'fixture' => $this->fixtureId
        ]);

        $desfalques = [];
        foreach ($playersData['response'] ?? [] as $p) {
            
            $playerStats = $this->request('/players', [
                'id' => $p['player']['id'],
                'season' => $this->temporadaAno,
                'league' => $this->ligaId
            ]);

            /** 
             * gols_esperados = ?? -> não tem mas vale a pena calcular em cima disso aqui: xG ≈ (chutes_no_gol * 0.3) + (chutes_totais * 0.05) ?
             * jogos_sem_sofrer_gol = ?? -> não tem informação direta, clean_sheet só tem para o TIME, vale a pena vazer diversas requisições e calculo pra ver? 
             */
            $desfalques[] = new DesfalqueDTO(
                noticia_ou_desfalque: 'desfalque',
                atleta: $p['player']['name'] ?? '', 
                posicao: $playerStats['response'][0]['statistics'][0]['games']['position'] ?? 'Desconhecida',
                motivo: $p['player']['reason'] ?? 'Desconhecido',
                Partidas: $playerStats['response'][0]['statistics'][0]['games']['appearences'] ?? 0,
                partidas_titular: $playerStats['response'][0]['statistics'][0]['games']['lineups'] ?? 0,
                total_minutos_jogados: $playerStats['response'][0]['statistics'][0]['games']['minutes'] ?? 0,
                nota_media: floatval($playerStats['response'][0]['statistics'][0]['games']['rating'] ?? 0),
                gols_sofridos_por_jogo: $playerStats['response'][0]['statistics'][0]['games']['appearences'] ? ($playerStats['response'][0]['statistics'][0]['goals']['conceded'] / $playerStats['response'][0]['statistics'][0]['games']['appearences']) : null,
                gols: $playerStats['response'][0]['statistics'][0]['goals']['total']['total'] ?? 0,
                gols_esperados: 0.0,
                assistencias: $playerStats['response'][0]['statistics'][0]['goals']['assists'] ?? 0,
                cartoes_amarelo: $playerStats['response'][0]['statistics'][0]['cards']['yellow'] ?? 0,
                cartoes_vermelho: $playerStats['response'][0]['statistics'][0]['cards']['red'] ?? 0,
                jogos_sem_sofrer_gol: null
            );
        }

        $standings = $this->request('/standings', [
            'league' => $this->ligaId,
            'season' => $this->temporadaAno,
            'team'   => $timeId
        ]);

        $formRecente = $statsData['response']['form'] ?? '';

        $dto = new TimeDTO(
            nome: $timeNome ?? 'Desconhecido',
            posicao_tabela: $standings['response'][0]['league']['standings'][0][0]['rank'],
            forma_recente_geral: $this->formatarForma($formRecente), 
            ultimos_jogos: $ultimosJogos,
            stats_season: $estatisticas,
            noticias_e_desfalques: $desfalques,
            fator_motivacional: '' // definir como vai ficar
        );

        return $tipo === 'casa' ? $dto->toArrayCasa() : $dto->toArrayFora();
    }


    /**
     * Calcula resultado do jogo para o time
     */
    private function getResultado(int $golsPro, int $golsContra): string
    {
        if ($golsPro > $golsContra) return 'V';
        if ($golsPro < $golsContra) return 'D';
        return 'E';
    }

    /** 
     * Somar cartões
     */
    private function somarCartoes(array $cards, string $tipo): int
    {
        $total = 0;

        foreach ($cards[$tipo] ?? [] as $intervalo) {
            if (isset($intervalo['total'])) {
                $total += (int) $intervalo['total'];
            }
        }

        return $total;
    }

    /**
     * Formatar Forma que vem como "WDLDWLDLDWLWDDWWDLWWLWLLDWWDWDWWWWDWDW"
     */
    private function formatarForma(string $form, int $limite = 5): array
    {
        $map = [
            'W' => 'V', 
            'D' => 'E', 
            'L' => 'D', 
        ];

        return collect(str_split($form))
            ->reverse()               // começa pelos jogos mais recentes
            ->take($limite)           // pega os últimos N
            ->map(fn ($f) => $map[$f] ?? null)
            ->filter()                // remove nulls
            ->values()
            ->toArray();
    }

}
