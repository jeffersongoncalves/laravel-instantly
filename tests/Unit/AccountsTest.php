<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Facades\Instantly;

beforeEach(function () {
    config(['instantly.api_key' => 'test-key']);
});

it('fetches account warmup status', function () {
    Http::fake(['*account/get/warmup*' => Http::response(['status' => 'warming'])]);

    Instantly::accounts()->warmupStatus('inbox@acme.com');

    Http::assertSent(fn ($request) => str_contains($request->url(), '/account/get/warmup')
        && $request['email'] === 'inbox@acme.com');
});
