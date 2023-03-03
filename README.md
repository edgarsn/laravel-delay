# Laravel Delay

Package which helps you to delay (sleep) your code for some time.

## Installation

### Requirements

- Laravel 8.12+, 9.0+, 10.0+
- PHP 8.0

### Installation

Require the package via Composer:

```bash
composer require newman/laravel-delay
```

## :book: Usage

### Using as Trait

```php 
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Newman\LaravelDelay\Traits\Delayable;

class ImportTask extends Command {
    use Delayable;
    
    // ...
}
```

then in code you can call the delay the code execution like this:

```php 
$this->delay()->for(5);
```

or

```php
$this->delay(5);
```

They both will delay execution for 5 seconds.

You can include trait in any class you'd like to use it, including controllers.

### Using as service container

```php
use Newman\LaravelDelay\Contracts\DelayContract;

// ...

app()->make(DelayContract::class)->for(5);
```

### Usage samples

Let's assume we're using Trait.

**Delay execution for 10 seconds:**

```php
$this->delay(10);
$this->delay()->for(10);
$this->delay()->forSeconds(10);
```

Note that in case you want to delay for fractions of a second, you should use `forMs` function.

**Delay execution for 1500 miliseconds (1.5 second):**

```php
$this->delay()->forMs(1500);
$this->delay()->forMiliseconds(1500);
```

**Delay execution for 5000 microseconds (0.005 second):**

```php
$this->delay()->forMicroseconds(5000);
```

**Delay execution till given Carbon datetime:**

```php
$this->delay()->till(Carbon::now()->addMinutes(5)->addSeconds(15));
```

**Delay execution for 10 seconds only on given environment/-s:**

```php
$this->delay()->for(10)->environments(['production']); // delays only on production
$this->delay()->for(10)->environments(['production', 'staging']); // delays on production and staging only
```

**Delay execution for 10 seconds except given environment/-s:**

```php
$this->delay()->for(10)->except(['prodction']); // delays on all environments, except production
$this->delay()->for(10)->except(['prodction', 'staging']); // delays on all environments, except production and staging
```

**Delay execution for 10 seconds only when callback returns false:**

```php
$this->delay()->for(10)->exceptWhen(fn () => 1 + 1 == 2); // code will not delay in this case, because callback returns true
$this->delay()->for(10)->exceptWhen(fn () => 1 + 1 == 3); // code will delay in this case, because callback returns false
```

and we can even pass multiple callbacks.

```php
$this->delay()->for(10)->exceptWhen(fn () => false)->exceptWhen(fn () => false); // code will delay
$this->delay()->for(10)->exceptWhen(fn () => true)->exceptWhen(fn () => false); // code will not delay, because all callbacks doesn't return false
```

**At last we can chain multiple conditions:**

It will delay for 10 seconds only on production & staging environments and only when it's not 10 AM.

```php
$this->delay()
    ->for(10)
    ->environments(['production', 'staging'])
    ->exceptWhen(fn () => Carbon::now()->hour == 10);
```

## :handshake: Contributing

We'll appreciate your collaboration to this package.

When making pull requests, make sure:

* All tests are passing: `composer test`
* Test coverage is not reduced: `composer test-coverage`
* There are no PHPStan errors: `composer phpstan`
* Coding standard is followed: `composer lint` or `composer fix-style` to automatically fix it. 
