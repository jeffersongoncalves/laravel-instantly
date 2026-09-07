<?php

namespace JeffersonGoncalves\Instantly\Resources;

use JeffersonGoncalves\Instantly\InstantlyClient;

class Analytics
{
    public function __construct(
        protected InstantlyClient $client,
    ) {}

    /** @param array<string, mixed> $filters */
    public function campaignSummary(string $campaignId, array $filters = []): array
    {
        return $this->client->post('/analytics/campaign/summary', array_filter([
            'campaign_id' => $campaignId,
            'start_date' => $filters['start_date'] ?? null,
            'end_date' => $filters['end_date'] ?? null,
        ], fn (mixed $value) => $value !== null));
    }

    /** @param array<string, mixed> $filters */
    public function campaignSteps(string $campaignId, array $filters = []): array
    {
        return $this->client->post('/analytics/campaign/step', array_filter([
            'campaign_id' => $campaignId,
            'start_date' => $filters['start_date'] ?? null,
            'end_date' => $filters['end_date'] ?? null,
        ], fn (mixed $value) => $value !== null));
    }

    public function accountCount(string $startDate, string $endDate): array
    {
        return $this->client->post('/analytics/campaign/count', [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }
}
