<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Exceptions\InstantlyException;
use JeffersonGoncalves\Instantly\Facades\Instantly;

beforeEach(function () {
    config(['instantly.api_key' => 'test-key']);
});

it('lists campaigns', function () {
    Http::fake(['*campaign/list*' => Http::response(['items' => []])]);

    Instantly::campaigns()->list(['limit' => 10]);

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && str_contains($request->url(), '/campaign/list')
        && $request['api_key'] === 'test-key'
        && $request['limit'] === 10);
});

it('launches a campaign', function () {
    Http::fake(['*campaign/launch*' => Http::response(['status' => 'ok'])]);

    Instantly::campaigns()->launch('abc-123');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/campaign/launch')
        && $request['campaign_id'] === 'abc-123'
        && $request['api_key'] === 'test-key');
});

it('throws on a failed response', function () {
    Http::fake(['*campaign/get*' => Http::response(['message' => 'not found'], 404)]);

    Instantly::campaigns()->get('missing');
})->throws(InstantlyException::class, 'not found');
