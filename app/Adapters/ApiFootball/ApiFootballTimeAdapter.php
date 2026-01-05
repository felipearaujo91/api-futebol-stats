<?php

namespace App\Adapters\ApiFootball;

use App\Contracts\TimeProviderInterface;
use App\Services\ApiFootballClient;
use App\DTO\TimeDTO;
use App\DTO\EstatisticasTimeDTO;
use App\DTO\DesfalqueDTO;

class ApiFootballTimeAdapter extends ApiFootballClient implements TimeProviderInterface
{
    public function getTimeCasa(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {
        return $this->buildTime(
            $timeId,
            'casa',
            $ligaId,
            $temporadaAno,
            $fixtureId,
            $nome
        );
    }

    public function getTimeFora(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {
        return $this->buildTime(
            $timeId,
            'fora',
            $ligaId,
            $temporadaAno,
            $fixtureId,
            $nome
        );
    }

    private function buildTime(
        int $timeId,
        string $tipo,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {

        $timeNome = $nome;

        // ========= STATISTICS =========
        $statsData = $this->request('/teams/statistics', [
            'team' => $timeId,
            'season' => $temporadaAno,
            'league' => $ligaId
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
            media_cartoes_recebidos:
                ($this->somarCartoes($stats['cards'], 'yellow') +
                 $this->somarCartoes($stats['cards'], 'red'))
                / max(1, ($stats['fixtures']['played']['total'] ?? 1)),
            posse_bola_media: 0
        );

        // ========= ÚLTIMOS JOGOS =========
        $lastFixtures = $this->request('/fixtures', [
            'team' => $timeId,
            'season' => $temporadaAno
        ]);

        $ultimosJogos = array_map(function ($f) use ($timeId) {
            $mandante = $f['teams']['home']['id'] === $timeId;
            $placar = ($f['goals']['home'] ?? '?') . '-' . ($f['goals']['away'] ?? '?');

            $resultado = $mandante
                ? $this->getResultado($f['goals']['home'] ?? 0, $f['goals']['away'] ?? 0)
                : $this->getResultado($f['goals']['away'] ?? 0, $f['goals']['home'] ?? 0);

            return "{$resultado} ({$placar})";
        }, $lastFixtures['response'] ?? []);

        // ========= DESFALQUES =========
        $playersData = $this->request('/injuries', [
            'team' => $timeId,
            'season' => $temporadaAno,
            'fixture' => $fixtureId
        ]);

        $desfalques = [];

        foreach ($playersData['response'] ?? [] as $p) {

            $playerStats = $this->request('/players', [
                'id' => $p['player']['id'],
                'season' => $temporadaAno,
                'league' => $ligaId
            ]);

            $stat = $playerStats['response'][0]['statistics'][0] ?? [];

            $desfalques[] = new DesfalqueDTO(
                noticia_ou_desfalque: 'desfalque',
                atleta: $p['player']['name'] ?? '',
                posicao: $stat['games']['position'] ?? 'Desconhecida',
                motivo: $p['player']['reason'] ?? 'Desconhecido',
                Partidas: $stat['games']['appearences'] ?? 0,
                partidas_titular: $stat['games']['lineups'] ?? 0,
                total_minutos_jogados: $stat['games']['minutes'] ?? 0,
                nota_media: floatval($stat['games']['rating'] ?? 0),
                gols_sofridos_por_jogo:
                    ($stat['games']['appearences'] ?? 0) > 0
                        ? (($stat['goals']['conceded'] ?? 0) / $stat['games']['appearences'])
                        : null,
                gols: $stat['goals']['total']['total'] ?? 0,
                gols_esperados: 0.0,
                assistencias: $stat['goals']['assists'] ?? 0,
                cartoes_amarelo: $stat['cards']['yellow'] ?? 0,
                cartoes_vermelho: $stat['cards']['red'] ?? 0,
                jogos_sem_sofrer_gol: null
            );
        }

        // ========= STANDINGS =========
        $standings = $this->request('/standings', [
            'league' => $ligaId,
            'season' => $temporadaAno,
            'team' => $timeId
        ]);

        $formRecente = $statsData['response']['form'] ?? '';

        $dto = new TimeDTO(
            nome: $timeNome ?? 'Desconhecido',
            posicao_tabela: $standings['response'][0]['league']['standings'][0][0]['rank'],
            forma_recente_geral: $this->formatarForma($formRecente),
            ultimos_jogos: $ultimosJogos,
            stats_season: $estatisticas,
            noticias_e_desfalques: $desfalques,
            fator_motivacional: ''
        );

        return $tipo === 'casa'
            ? $dto->toArrayCasa()
            : $dto->toArrayFora();
    }

    private function getResultado(int $golsPro, int $golsContra): string
    {
        if ($golsPro > $golsContra) return 'V';
        if ($golsPro < $golsContra) return 'D';
        return 'E';
    }

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

    private function formatarForma(string $form, int $limite = 5): array
    {
        $map = ['W' => 'V', 'D' => 'E', 'L' => 'D'];

        return collect(str_split($form))
            ->reverse()
            ->take($limite)
            ->map(fn ($f) => $map[$f] ?? null)
            ->filter()
            ->values()
            ->toArray();
    }
}
