<?php

namespace App\Services;

use App\Contracts\ArbitragemProviderInterface;

class ArbitragemService
{
    public function __construct(
        protected ArbitragemProviderInterface $provider
    ) {}

    public function get(int $fixtureId): array
    {
        return $this->provider
            ->getByFixture($fixtureId)
            ->toArray();
    }
}
