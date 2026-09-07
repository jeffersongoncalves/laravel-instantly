<?php

namespace JeffersonGoncalves\Instantly\Resources;

use JeffersonGoncalves\Instantly\InstantlyClient;

class Accounts
{
    public function __construct(
        protected InstantlyClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function list(array $filters = []): array
    {
        $query = array_filter([
            'limit' => $filters['limit'] ?? null,
            'skip' => $filters['skip'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get('/account/list', $query);
    }

    public function status(string $email): array
    {
        return $this->client->get('/account/get/status', ['email' => $email]);
    }

    public function warmupStatus(string $email): array
    {
        return $this->client->get('/account/get/warmup', ['email' => $email]);
    }
}
