<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Instantly\Facades\Instantly;

beforeEach(function () {
    config(['instantly.api_key' => 'test-key']);
});

it('adds a lead', function () {
    Http::fake(['*lead/add*' => Http::response(['status' => 'ok'])]);

    Instantly::leads()->add('camp-1', ['email' => 'lead@acme.com']);

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && str_contains($request->url(), '/lead/add')
        && $request['campaign_id'] === 'camp-1'
        && $request['leads'][0]['email'] === 'lead@acme.com');
});

it('requires an email to add a lead', function () {
    Instantly::leads()->add('camp-1', []);
})->throws(InvalidArgumentException::class);

it('deletes a lead', function () {
    Http::fake(['*lead/delete*' => Http::response(['status' => 'ok'])]);

    Instantly::leads()->delete('camp-1', 'lead@acme.com');

    Http::assertSent(fn ($request) => $request['delete_list'][0] === 'lead@acme.com');
});
