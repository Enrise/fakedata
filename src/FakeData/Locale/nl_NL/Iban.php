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

class Iban extends \Enrise\FakeData\Iban
{
    protected $countryConstraints = [
        'length' => 10, // 18 - strlen('NL00AAAA')
        'bankcodes' => [
            [
                self::CC_BANKCODE => 'INGB',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 7,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 8
            ],
            [
                self::CC_BANKCODE => 'RABO',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 9,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 10
            ],
            [
                self::CC_BANKCODE => 'ABNA',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 9,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 10
            ],
            [
                self::CC_BANKCODE => 'FRBK',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 9,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 10
            ],
            [
                self::CC_BANKCODE => 'SNSB',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 9,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 10
            ],
            [
                self::CC_BANKCODE => 'FVLB',
                self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH => 9,
                self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH => 10
            ]
        ]
    ];

    /**
     * @inheritDoc
     */
    protected function isValidBankAccountNumber($value)
    {
        if ($this->isGiroNumber($value)) {
            return true;
        }
        return $this->passesElfProef($value);
    }

    /**
     * @inheritDoc
     */
    protected function getDefaultOptions()
    {
        return parent::getDefaultOptions()->merge([Options::OPTION_COUNTRYCODE => 'NL']);
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
     * @param $value
     * @return int
     */
    protected function isGiroNumber($value)
    {
        return preg_match('~^[Pp]?(000)?[0-9]{3,7}$~', $value);
    }
}
