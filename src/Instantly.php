<?php

namespace JeffersonGoncalves\Instantly;

use JeffersonGoncalves\Instantly\Resources\Accounts;
use JeffersonGoncalves\Instantly\Resources\Analytics;
use JeffersonGoncalves\Instantly\Resources\Blocklist;
use JeffersonGoncalves\Instantly\Resources\Campaigns;
use JeffersonGoncalves\Instantly\Resources\Leads;

/**
 * Entry point exposing one resource per Instantly.ai API v1 group.
 */
class Instantly
{
    protected InstantlyClient $client;

    public function __construct(string $apiKey, string $baseUrl = 'https://api.instantly.ai/api/v1')
    {
        $this->client = new InstantlyClient($apiKey, $baseUrl);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this->client);
    }

    public function leads(): Leads
    {
        return new Leads($this->client);
    }

    public function accounts(): Accounts
    {
        return new Accounts($this->client);
    }

    public function analytics(): Analytics
    {
        return new Analytics($this->client);
    }

    public function blocklist(): Blocklist
    {
        return new Blocklist($this->client);
    }
}
