<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiFootballClient
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api_football.base_url');
    }

    public function request(string $endpoint, array $params = [])
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'x-apisports-key' => config('services.api_football.key'),
            ])
            ->timeout(10)
            ->retry(2, 500)
            ->get($endpoint, $params)
            ->throw()
            ->json();
    }
}
