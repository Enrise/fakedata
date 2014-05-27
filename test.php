<?php
require_once 'vendor/autoload.php';

$iban = new \Enrise\FakeData\Locale\nl_NL\Iban();

echo 'Valid numbers: ' . PHP_EOL;
for ($i = 0; $i < 10; $i++) {
    echo $iban->generate([]) . PHP_EOL;
}

echo PHP_EOL . 'Invalid numbers: ' . PHP_EOL;
for ($i = 0; $i < 10; $i++) {
    echo $iban->generate([$iban::OPTION_VALID => false]) . PHP_EOL;
}
