# Enrise fake data generator classes

Generates fake, localized data. Currently only supports invalid and valid dutch IBAN numbers.
Currently only supports invalid and valid IBAN numbers.

## IBAN generation
This library generates dutch IBAN numbers that are truly valid. They comply to the dutch
[Elfproef](http://nl.wikipedia.org/wiki/Elfproef) when required.
It also generates invalid IBAN numbers, if you need some of those.


## Other types of localized data
For other types of (localized) fake data, please refer to [fzaninotto/Faker](https://github.com/fzaninotto/Faker).

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
