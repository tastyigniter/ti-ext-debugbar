## Introduction

The TastyIgniter DebugBar extension a seamless integration of [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar) and [ide-helper](https://github.com/barryvdh/laravel-ide-helper), is a powerful tool for developers. It provides a convenient way to profile your TastyIgniter application and generate helper files for IDEs, making local development a breeze.

## Features

- **Profiling:** Measure and visualize the performance of your application.
- **Database Queries:** Monitor and optimize your database queries.
- **IDE Helper:** Generate helper files for your IDE to improve code completion and navigation.

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-debugbar:"^4.0" -W
```

## Getting started

To enable the DebugBar, set `APP_DEBUG` to `true` in your `.env` file. Once enabled, the DebugBar will appear at the bottom of all admin pages. Please note, you must be logged in as an admin to view the DebugBar on the frontend.

## Usage

### Profiling

You can measure the time of your code execution by using the `Debugbar` facade:

```php
use Debugbar;

Debugbar::startMeasure('render','Time for rendering');

// Do something

Debugbar::stopMeasure('render');
```

### Generating IDE Helper files

To generate IDE helper files, which improve code completion and navigation in your IDE, run the following command:

```bash
php artisan ide-helper:generate
```

## Changelog

Please see [CHANGELOG](https://github.com/tastyigniter/ti-ext-debugbar/blob/master/CHANGELOG.md) for more information on what has changed recently.

## Reporting issues

If you encounter a bug in this extension, please report it using the [Issue Tracker](https://github.com/tastyigniter/ti-ext-debugbar/issues) on GitHub.

## Contributing

Contributions are welcome! Please read [TastyIgniter's contributing guide](https://tastyigniter.com/docs/contribution-guide).

## Security vulnerabilities

For reporting security vulnerabilities, please see our [our security policy](https://github.com/tastyigniter/ti-ext-debugbar/security/policy).

## License

TastyIgniter Coupons extension is open-source software licensed under the [MIT license](https://github.com/tastyigniter/ti-ext-debugbar/blob/master/LICENSE.md).
