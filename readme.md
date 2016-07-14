[![Total Downloads](https://poser.pugx.org/mengidd/disqus/downloads)](https://packagist.org/packages/mengidd/disqus)

## Installation

Run the following command to install:
```bash
composer require mengidd/disqus
```

Register the service provider with Laravel by adding it to the providers array in `config/app.php`:
```php
Mengidd\Disqus\Providers\DisqusServiceProvider::class,
```

Eventually add the facade if you like such things:
```php
'Disqus' => Mengidd\Disqus\Facades\DisqusFacade::class,
```

Publish the configuration file:
```bash
php artisan vendor:publish
```

Update the configuration file `config/disqus.php` with your API keys.


## Example Usage

You may use the Facade if you want to:
```php
$posts = \Disqus::postsList()->get();
```

Or you can use the direct resource classes:
```php
use Mengidd\Disqus\Resources\PostsList;

$postsList = new PostsList();
$posts = $postsList->get();
```

##### Filters / Parameters

Fluent filter setters is used to make it simple to filter entries.
```php
$date = new DateTime('first day of January 2015');

$posts = \Disqus::postsList()
    ->related(['thread'])
    ->limit(100)
    ->since($date)
    ->get();
```
To see all available methods check out the class file (API docs is under way).
All the filter methods are named to match the Disqus API parameters, so you might check out the Disqus API aswell.

## Current API coverage

So far only posts/list and threads/list is supported. I plan on adding the rest of the API but time is limited, feel free to send pull requests.