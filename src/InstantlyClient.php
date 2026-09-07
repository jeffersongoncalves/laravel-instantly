<?php

namespace JeffersonGoncalves\Instantly;

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Exceptions\InstantlyException;

/**
 * Thin wrapper around Laravel's Http client for the Instantly.ai REST API v1.
 *
 * Instantly authenticates via an "api_key" field: as a query string param on
 * every GET, and merged into the JSON body of every POST — replicating the
 * exact auth mechanism of Instantly's own reference clients.
 *
 * ponytail: Http::retry() already covers transient-failure retries if ever
 * needed later — no custom retry/backoff layer built here speculatively.
 */
class InstantlyClient
{
    public function __construct(
        protected string $apiKey,
        protected string $baseUrl = 'https://api.instantly.ai/api/v1',
    ) {}

    /** @param array<string, mixed> $query */
    public function get(string $path, array $query = []): array
    {
        $query['api_key'] = $this->apiKey;

        $response = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->get($path, $query);

        if ($response->failed()) {
            throw InstantlyException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }

    /** @param array<string, mixed> $body */
    public function post(string $path, array $body = []): array
    {
        $body['api_key'] = $this->apiKey;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
            ->baseUrl($this->baseUrl)
            ->post($path, $body);

        if ($response->failed()) {
            throw InstantlyException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
