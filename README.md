# Tokenex [![Build Status](https://travis-ci.org/cliffom/tokenex-php.svg?branch=master)](https://travis-ci.org/cliffom/tokenex-php)

A convenient PHP package for the TokenEx API

## Installation

The fastest way to get up and running is to install via [composer](https://getcomposer.org/):

```bash
$ composer require cliffom/tokenex
```

## Usage

### Tokenization

#### Initialize your tokenizer

```php
require __DIR__ . '/vendor/autoload.php';
use Cliffom\Tokenex\Tokenizer;

$tokenizer = new Tokenizer($TOKENEX_API_BASE_URL, $TOKENEX_ID, $TOKENEX_API_KEY);
```

#### Create a token

```php
// From a credit card number
$token = $tokenizer->token_from_ccnum(4242424242424242);

// From arbitrary data
$token = $tokenizer->tokenize("This is random data containing 3 numbers less than 10");
```

#### Validate a token

```php
$tokenizer->validate_token($token); // true or false
```

#### Delete a token

```php
$tokenizer->delete_token($token); // true or false
```

#### Errors and References

Each action call will return a reference ID that can be used to lookup a call in the TokenEx dashboard. Unsuccessful calls will also return an error describing the problem. Each can be accessed via:

```php
var_dump($tokenizer->error); // array, empty if no errors
var_dump($tokenizer->reference_number); // string
```

## Development

Use the following docker-compose commands to install dependencies and run the specs:

```
docker-compose run --rm tokenex composer install
docker-compose up
```

## Contributing

Bug reports and pull requests are welcome on GitHub at https://github.com/cliffom/tokenex-php.

## License

All code is open source under the terms of the [MIT License](MIT License)
