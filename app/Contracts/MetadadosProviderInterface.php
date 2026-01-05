<?php 

namespace App\Contracts;

interface MetadadosProviderInterface
{
    public function getFixtureById(int $fixtureId): array;
}
