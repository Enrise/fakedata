<?php
/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2014 Enrise
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author Richard Tuin <richard@enrise.com>
 */
namespace Enrise\FakeData\Locale\nl_NL;

use Enrise\FakeData\Options;

class BankAccount extends \Enrise\FakeData\BankAccount
{
    protected $accountLength = [
        Options::BANKACCOUNTTYPE_PAYMENT => 9,
        Options::BANKACCOUNTTYPE_SAVINGS => 10,
    ];

    public function isValidBankAccountNumber($value)
    {
        return $this->passesElfProef($value);
    }

    /**
     * Tests whether the given value passes the so-called elfproef.
     *
     * @link http://nl.wikipedia.org/wiki/Elfproef
     * @param $value
     * @return bool
     */
    protected function passesElfProef($value)
    {
        $length = strlen($value);
        $total  = 0;
        for ($i = 0; $i <= $length; $i++) {
            $number = (int)substr($value, $length - $i, 1);
            $total += ($i * $number);
        }

        return (0 == $total % 11);
    }

    /**
     * Generate a random dutch bank account number
     *
     * @param $accountType
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function generateRandomAccountNumber($accountType)
    {
        if ($accountType == (Options::BANKACCOUNTTYPE_PAYMENT | Options::BANKACCOUNTTYPE_SAVINGS)) {
            $accountType = rand(Options::BANKACCOUNTTYPE_PAYMENT, Options::BANKACCOUNTTYPE_SAVINGS);
        }

        if ($accountType == Options::BANKACCOUNTTYPE_PAYMENT) {
            $length = $this->accountLength[$accountType];
        } elseif ($accountType == Options::BANKACCOUNTTYPE_SAVINGS) {
            $length = $this->accountLength[$accountType];
        } else {
            throw new \InvalidArgumentException('Invalid account type provided');
        }

        return (string)rand((int)str_pad('1', $length, '0'), (int)str_pad('9', $length, '0'));
    }
}
