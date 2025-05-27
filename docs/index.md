---
title: "Debugbar"
section: "extensions"
sortOrder: 140
---

## Installation

You can install the extension via composer using the following command:

```bash
composer require tastyigniter/ti-ext-debugbar -W
```

## Getting started

The DebugBar extension integrates the Laravel Debugbar into TastyIgniter, providing a powerful debugging tool for developers. It allows you to inspect and profile your application easily, offering insights into queries, routes, views, and more.

To enable the DebugBar, set `APP_DEBUG` to `true` in your `.env` file. Once enabled, the DebugBar will appear at the bottom of all admin pages. Please note, you must be logged in as an admin to view the DebugBar on the frontend.

For more information on how to use or configure the DebugBar, refer to the [Laravel Debugbar documentation](https://github.com/barryvdh/laravel-debugbar)

## Usage

This section explains how to use the _DebugBar_ in your own extension if you need to debug your code or profile its performance.

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
