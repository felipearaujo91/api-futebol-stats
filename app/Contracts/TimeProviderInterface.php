<?php

namespace App\Contracts;

interface TimeProviderInterface
{
    public function getTimeCasa(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array;

    public function getTimeFora(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array;
}
