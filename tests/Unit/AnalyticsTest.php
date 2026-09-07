<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Facades\Instantly;

beforeEach(function () {
    config(['instantly.api_key' => 'test-key']);
});

it('fetches campaign summary analytics', function () {
    Http::fake(['*analytics/campaign/summary*' => Http::response(['sent' => 100])]);

    Instantly::analytics()->campaignSummary('camp-1', ['start_date' => '2026-01-01']);

    Http::assertSent(fn ($request) => $request['campaign_id'] === 'camp-1'
        && $request['start_date'] === '2026-01-01'
        && ! isset($request['end_date']));
});

it('fetches account-level counts', function () {
    Http::fake(['*analytics/campaign/count*' => Http::response(['count' => 5])]);

    Instantly::analytics()->accountCount('2026-01-01', '2026-01-31');

    Http::assertSent(fn ($request) => $request['start_date'] === '2026-01-01'
        && $request['end_date'] === '2026-01-31');
});
