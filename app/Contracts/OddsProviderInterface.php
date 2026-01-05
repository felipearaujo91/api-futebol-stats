<?php

namespace App\Contracts;

use App\DTO\OddsDTO;

interface OddsProviderInterface
{
    public function getOddsByFixture(int $fixtureId): OddsDTO;
}
