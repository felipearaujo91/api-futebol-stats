<?php

namespace App\Services;

use App\Services\ApiFootballClient;

class TimeService extends ApiFootballClient
{
    public function findById(int $idTime)
    {
        return $this->request('/teams', [
            'id' => $idTime
        ]);
    }
}
