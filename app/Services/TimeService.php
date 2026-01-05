<?php

namespace App\Services;

use App\Contracts\TimeProviderInterface;

class TimeService
{
    public function __construct(
        protected TimeProviderInterface $provider
    ) {}

    public function getCasa(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome,
    ): array {
        return $this->provider->getTimeCasa(
            $timeId,
            $ligaId,
            $temporadaAno,
            $fixtureId,
            $nome
        );
    }

    public function getFora(
        int $timeId,
        int $ligaId,
        int $temporadaAno,
        int $fixtureId,
        string $nome
    ): array {
        return $this->provider->getTimeFora(
            $timeId,
            $ligaId,
            $temporadaAno,
            $fixtureId,
            $nome
        );
    }
}
