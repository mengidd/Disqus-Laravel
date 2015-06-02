[![Total Downloads](https://poser.pugx.org/mengidd/disqus/downloads)](https://packagist.org/packages/mengidd/disqus)

## Installation

Run the following command to install:
```bash
composer require mengidd/disqus
```

or add the following to your `composer.json` file and run `composer update`:
```json
"mengidd/disqus": "1.0.*"
```

Register the service provider with Laravel:
```php
'Mengidd\Disqus\Providers\DisqusServiceProvider',
```

Publish the configuration file:
```bash
php artisan vendor:publish
```

Update the configuration file `config/disqus.php` with your API keys.


## Usage

To use the class, simply put this among your use statements in your file:
```php
use Mengidd\Disqus\Disqus;
```

You can then use the API like this:
```php
$disqus = new Disqus();

// Example API call
$disqus->threads->list();
```

Documentation on methods and API usage can be found at http://disqus.com/api/