<?php

namespace JeffersonGoncalves\Instantly\Resources;

use InvalidArgumentException;
use JeffersonGoncalves\Instantly\InstantlyClient;

class Leads
{
    public function __construct(
        protected InstantlyClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function list(string $campaignId, array $filters = []): array
    {
        $query = array_filter([
            'campaign_id' => $campaignId,
            'limit' => $filters['limit'] ?? null,
            'skip' => $filters['skip'] ?? null,
        ], fn (mixed $value) => $value !== null);

        return $this->client->get('/lead/get', $query);
    }

    /** @param array<string, mixed> $lead */
    public function add(string $campaignId, array $lead): array
    {
        if (empty($lead['email'])) {
            throw new InvalidArgumentException('The "email" key is required.');
        }

        return $this->client->post('/lead/add', [
            'campaign_id' => $campaignId,
            'leads' => [$lead],
        ]);
    }

    public function delete(string $campaignId, string $email): array
    {
        return $this->client->post('/lead/delete', [
            'campaign_id' => $campaignId,
            'delete_list' => [$email],
        ]);
    }

    public function status(string $campaignId, string $email): array
    {
        return $this->client->get('/lead/get/status', [
            'campaign_id' => $campaignId,
            'email' => $email,
        ]);
    }
}
