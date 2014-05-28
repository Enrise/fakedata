<?php
require_once 'vendor/autoload.php';

$generator = new \Enrise\FakeData\Locale\nl_NL\BankAccount();
echo $generator->generate() . PHP_EOL;
