<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiFootballClient
{
    protected string $baseUrl;
    protected bool $debug = false;

    public function __construct()
    {
        $this->baseUrl = config('services.api_football.base_url');
    }

    public function request(string $endpoint, array $params = [])
    {
        $client = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'x-apisports-key' => config('services.api_football.key'),
            ])
            ->timeout(10)
            ->retry(2, 500);

        $response = $client->get($endpoint, $params);

        $data = $response->json();

        if ($this->debug) {
            $fullUrl = $this->baseUrl . $endpoint . '?' . http_build_query($params);
            dd([
                'URL_chamada' => $fullUrl,
                'Headers' => [
                    'x-apisports-key' => config('services.api_football.key'),
                ],
                'Params' => $params,
                'Status_code' => $response->status(),
                'Response' => $data,
            ]);
        }

        // Verifica se a API retornou erro
        if (!empty($data['errors']) || ($data['results'] ?? 0) === 0) {
            $msg = $data['errors'] ?? ['API retornou 0 resultados'];
            throw new \Exception('Erro na API Football: ' . json_encode($msg));
        }

        return $data;
    }


}
