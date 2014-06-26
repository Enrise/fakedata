# Enrise fake data generator classes

Generates fake, localized data. Currently only supports invalid and valid dutch IBAN numbers.
Currently only supports invalid and valid IBAN numbers.

## IBAN generation
This library generates dutch IBAN numbers that are truly valid. They comply to the dutch
[Elfproef](http://nl.wikipedia.org/wiki/Elfproef) when required.
It also generates invalid IBAN numbers, if you need some of those.


## Other types of localized data
For other types of (localized) fake data, please refer to [fzaninotto/Faker](https://github.com/fzaninotto/Faker).

## Examples
Generate valid dutch bank account numbers:
```php
$generator = new \Enrise\FakeData\Locale\nl_NL\BankAccount();
echo $generator->generate() . PHP_EOL;
```

Generate valid and invalid IBAN numbers:
```php
$iban = new \Enrise\FakeData\Locale\nl_NL\Iban();

echo 'Valid numbers: ' . PHP_EOL;
for ($i = 0; $i < 10; $i++) {
    echo $iban->generate() . PHP_EOL;
}

echo PHP_EOL . 'Invalid numbers: ' . PHP_EOL;
for ($i = 0; $i < 10; $i++) {
    echo $iban->generate([$iban::OPTION_VALID => false]) . PHP_EOL;
}
```

# Contributing
New localizations of the fake data this library provides is always welcome.

Keep in mind that your contributions comply to the following standards:

1. PSR-2 for code style
2. PSR-4 for autoloading
3. Your contributions contain tests

You can easily verify this by running phing (after installing composer dev dependencies):
```bash
$ vendor/bin/phing
```

Brought to you by [Enrise](http://www.enrise.com/) &mdash; Code Cuisine
