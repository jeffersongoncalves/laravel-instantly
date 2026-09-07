<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Facades\Instantly;

beforeEach(function () {
    config(['instantly.api_key' => 'test-key']);
});

it('adds entries to the blocklist', function () {
    Http::fake(['*blocklist/add*' => Http::response(['status' => 'ok'])]);

    Instantly::blocklist()->add(['spam.com', 'bad@spam.com']);

    Http::assertSent(fn ($request) => $request['entries'] === ['spam.com', 'bad@spam.com']);
});

it('requires at least one entry', function () {
    Instantly::blocklist()->add([]);
})->throws(InvalidArgumentException::class);
