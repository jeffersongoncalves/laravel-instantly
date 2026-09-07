<?php

namespace JeffersonGoncalves\Instantly\Resources;

use JeffersonGoncalves\Instantly\InstantlyClient;

class Campaigns
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

        return $this->client->get('/campaign/list', $query);
    }

    public function get(string $campaignId): array
    {
        return $this->client->get('/campaign/get', ['campaign_id' => $campaignId]);
    }

    public function status(string $campaignId): array
    {
        return $this->client->get('/campaign/get/status', ['campaign_id' => $campaignId]);
    }

    public function launch(string $campaignId): array
    {
        return $this->client->post('/campaign/launch', ['campaign_id' => $campaignId]);
    }

    public function pause(string $campaignId): array
    {
        return $this->client->post('/campaign/pause', ['campaign_id' => $campaignId]);
    }
}
