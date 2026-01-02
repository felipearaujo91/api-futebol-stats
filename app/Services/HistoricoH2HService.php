<?php

namespace App\Services;

use App\DTO\HistoricoH2HDTO;

class HistoricoH2HService
{
    public function get(): array
    {
        return [
            new HistoricoH2HDTO(
                data: '2025-05-11',
                competicao: 'Premier League',
                mandante: 'Man Utd',
                placar: '0-2',
                resumo: 'United teve mais volume, mas perdeu'
            )
        ];
    }
}
