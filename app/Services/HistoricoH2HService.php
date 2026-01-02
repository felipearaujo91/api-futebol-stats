<?php

namespace App\Services;

use App\DTO\HistoricoH2HDTO;
use App\Services\ApiFootballClient;

class HistoricoH2HService extends ApiFootballClient
{
    /**
     * Retorna histórico de confrontos entre dois times
     *
     * @param int $timeCasaId
     * @param int $timeForaId
     * @param int $limite
     */
    public function get(int $timeCasaId, int $timeForaId, int $limite = 5): array
    {
        $data = $this->request('/fixtures/headtohead', [
            'h2h' => "{$timeCasaId}-{$timeForaId}",
        ]);

        $fixtures = $data['response'] ?? [];

        // Ordena por data do mais recente para o mais antigo
        usort($fixtures, function ($a, $b) {
            return strtotime($b['fixture']['date']) <=> strtotime($a['fixture']['date']);
        });

        // Pega os últimos $limite jogos
        $ultimosFixtures = array_slice($fixtures, 0, $limite);

        $historico = [];

        foreach ($ultimosFixtures as $f) {
            $historico[] = (new HistoricoH2HDTO(
                data: date('Y-m-d', strtotime($f['fixture']['date'])),
                competicao: $f['league']['name'] ?? null,
                mandante: $f['teams']['home']['name'] ?? null,
                placar: ($f['goals']['home'] ?? '?') . '-' . ($f['goals']['away'] ?? '?'),
                resumo: null // depois temos que ver como vai ficar
            ))->toArray();
        }

        return $historico;
    }
}
