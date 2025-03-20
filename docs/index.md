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
