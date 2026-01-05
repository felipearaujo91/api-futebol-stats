<?php

namespace App\Contracts;

use App\DTO\ArbitragemDTO;

interface ArbitragemProviderInterface
{
    public function getByFixture(int $fixtureId): ArbitragemDTO;
}
