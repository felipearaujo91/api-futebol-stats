<?php

namespace App\Services;

use App\DTO\HistoricoH2HDTO;
use App\Services\ApiFootballClient;
use App\Contracts\HistoricoH2HProviderInterface;
use Carbon\Carbon;

class HistoricoH2HService extends ApiFootballClient
{

    public function __construct(
        private readonly HistoricoH2HProviderInterface $provider
    ) {}

    /**
     * Retorna histórico de confrontos entre dois times
     *
     * @param int $timeCasaId
     * @param int $timeForaId
     */
    public function get(int $timeCasaId, int $timeForaId): array
    {
        $limite = 5;
        $items = $this->provider->getH2H(
            $timeCasaId,
            $timeForaId,
            $limite
        );

        return array_map(fn ($item) =>
            (new HistoricoH2HDTO(
                data: Carbon::parse($item['data'])->format('Y-m-d'),
                competicao: $item['competicao'],
                mandante: $item['mandante'],
                placar: $item['placar'],
                resumo: $item['resumo'],
            ))->toArray()
        , $items);

    }
}
