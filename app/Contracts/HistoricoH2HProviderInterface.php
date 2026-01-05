<?php 

namespace App\Contracts;

interface HistoricoH2HProviderInterface
{
    public function getH2H(int $timeCasaId, int $timeForaId, ?int $limite): array;
}
