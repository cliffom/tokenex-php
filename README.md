# Tokenex [![Build Status](https://travis-ci.org/cliffom/tokenex-php.svg?branch=master)](https://travis-ci.org/cliffom/tokenex-php)

A convenient PHP package for the TokenEx API

## Usage

```bash
$ composer require cliffom/tokenex
```

```php
<?php
require __DIR__ . '/vendor/autoload.php';
use Cliffom\Tokenex\Tokenizer;

$tokenizer = new Tokenizer($TOKENEX_API_BASE_URL, $TOKENEX_ID, $TOKENEX_API_KEY);

$token = $tokenizer->token_from_ccnum(4242424242424242);
var_dump($tokenizer->validate_token($token));
var_dump($token);
var_dump($tokenizer->delete_token($token));
```

## Development

Use the following docker-compose commands to install dependencies and run the specs:

```
docker-compose run --rm tokenex composer install
docker-compose run --rm tokenex vendor/bin/phpspec run
```
