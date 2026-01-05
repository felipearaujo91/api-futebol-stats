<?php

namespace App\Services;

use App\Contracts\OddsProviderInterface;
use App\DTO\OddsDTO;

class OddsService
{
    public function __construct(
        protected OddsProviderInterface $provider
    ) {}

    public function get(int $fixtureId): array
    {
        return $this->provider
            ->getOddsByFixture($fixtureId)
            ->toArray();
    }
}
