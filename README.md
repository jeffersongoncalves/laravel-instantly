<div class="filament-hidden">

![Laravel Instantly](https://raw.githubusercontent.com/jeffersongoncalves/laravel-instantly/main/art/jeffersongoncalves-laravel-instantly.png)

</div>

# Laravel Instantly

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-instantly.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-instantly)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-instantly/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-instantly/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-instantly/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-instantly/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-instantly.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-instantly)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-instantly.svg?style=flat-square)](LICENSE.md)

A Laravel client for the [Instantly.ai](https://instantly.ai) v1 REST API. A fluent `Instantly` facade covers cold-email campaigns, leads, warm-up accounts, analytics and the blocklist, authenticates every request with the `api_key` parameter, and throws an `InstantlyException` on a non-2xx response instead of returning a silent error array.

## Features

- **Campaigns** — `list()`, `get()`, `status()`, `launch()`, `pause()`
- **Leads** — `list()`, `add()`, `delete()`, `status()`
- **Accounts** — `list()`, `status()`, `warmupStatus()`
- **Analytics** — `campaignSummary()`, `campaignSteps()`, `accountCount()`
- **Blocklist** — `list()`, `add()`
- **Thin by design** — every method returns the raw decoded JSON response as an array, no DTOs
- **Fails loud** — required parameters throw `InvalidArgumentException`; a non-2xx API response throws `InstantlyException` carrying the API's error message and HTTP status code

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-instantly
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="instantly-config"
```

## Configuration

Add to your `.env`:

```env
INSTANTLY_API_KEY=your-api-key
```

Find your API key in Instantly under Settings → Integrations.

### Config Options

```php
// config/instantly.php
return [
    'api_key' => env('INSTANTLY_API_KEY'),
    'base_url' => env('INSTANTLY_BASE_URL', 'https://api.instantly.ai/api/v1'),
];
```

## Usage

```php
use JeffersonGoncalves\Instantly\Facades\Instantly;
use JeffersonGoncalves\Instantly\Exceptions\InstantlyException;
```

### Campaigns

```php
Instantly::campaigns()->list(limit: 10, skip: 0);
Instantly::campaigns()->get('campaign-id');
Instantly::campaigns()->status('campaign-id');
Instantly::campaigns()->launch('campaign-id');
Instantly::campaigns()->pause('campaign-id');
```

### Leads

```php
Instantly::leads()->list('campaign-id', limit: 10);
Instantly::leads()->add('campaign-id', [
    'email' => 'lead@acme.com',
    'first_name' => 'Jane',
    'last_name' => 'Doe',
    'company_name' => 'Acme',
]);
Instantly::leads()->delete('campaign-id', 'lead@acme.com');
Instantly::leads()->status('campaign-id', 'lead@acme.com');
```

### Accounts

```php
Instantly::accounts()->list(limit: 10);
Instantly::accounts()->status('inbox@acme.com');
Instantly::accounts()->warmupStatus('inbox@acme.com');
```

### Analytics

```php
Instantly::analytics()->campaignSummary('campaign-id', start_date: '2026-01-01', end_date: '2026-01-31');
Instantly::analytics()->campaignSteps('campaign-id');
Instantly::analytics()->accountCount('2026-01-01', '2026-01-31');
```

### Blocklist

```php
Instantly::blocklist()->list();
Instantly::blocklist()->add(['spam.com', 'bad@spam.com']);
```

### Handling errors

```php
try {
    $result = Instantly::campaigns()->launch('campaign-id');
} catch (InstantlyException $e) {
    // $e->getMessage() — the API's error message, or the raw response body
    // $e->errorBody()   — the full decoded JSON error response
} catch (InvalidArgumentException $e) {
    // a required parameter was empty
}
```

## Testing

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Code Formatting

```bash
composer format
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [Jefferson Simão Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
