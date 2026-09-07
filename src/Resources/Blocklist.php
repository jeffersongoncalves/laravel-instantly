<?php

namespace JeffersonGoncalves\Instantly\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Instantly\InstantlyClient;

class Blocklist
{
    public function __construct(
        protected InstantlyClient $client,
    ) {}

    public function list(): array
    {
        return $this->client->get('/blocklist');
    }

    /** @param array<int, string> $entries emails or domains */
    public function add(array $entries): array
    {
        if (empty($entries)) {
            throw new InvalidArgumentException('The "entries" array must not be empty.');
        }

        return $this->client->post('/blocklist/add', ['entries' => $entries]);
    }
}
