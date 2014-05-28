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
 * @author Richard Tuin
 */

namespace Enrise\FakeData;

abstract class Iban
{
    protected $countryConstraints = [];

    const CC_BANKCODE = 'bankcode';
    const CC_ACCOUNTNUMBER_PAYMENT_LENGTH = 'payment_length';
    const CC_ACCOUNTNUMBER_SAVINGS_LENGTH = 'savings_length';

    /**
     * Generate an IBAN number based on the given options
     *
     * @param array $options
     * @return string
     */
    public function generate(Options $options = null)
    {
        if ($options == null) {
            $options = $this->getDefaultOptions();
        } else {
            $options = $this->getDefaultOptions()->merge($options);
        }

        $iban = $this->generateIbanNumber(
            $options[Options::OPTION_COUNTRYCODE],
            $options[Options::OPTION_BANKACCOUNTTYPE],
            $options[Options::OPTION_VALID]
        );
        $checkDigits = $this->generateCheckDigits($iban, $options[Options::OPTION_COUNTRYCODE]);
        return sprintf('%s%s%s', $options[Options::OPTION_COUNTRYCODE], $checkDigits, $iban);
    }

    /**
     * @param $countryCode
     * @param $accountType
     * @param $valid
     * @return string
     */
    protected function generateIbanNumber($countryCode, $accountType, $valid)
    {
        $length = $this->getAccountNumberLength($countryCode);

        $bankcodes = $this->countryConstraints['bankcodes'];
        $bankCode = $bankcodes[array_rand($bankcodes)];

        do {
            $bankAccountNumber = $this->generateRandomAccountNumber($bankCode, $accountType);
        } while ($this->isValidBankAccountNumber($bankAccountNumber) != $valid);

        return sprintf(
            '%s%s',
            $bankCode[self::CC_BANKCODE],
            str_pad((string)$bankAccountNumber, $length, '0', STR_PAD_LEFT)
        );
    }

    /**
     * Tests whether the given bank account number is valid according to localized constraints
     *
     * @param $value
     * @return bool whether the given bank account number is valid
     */
    abstract protected function isValidBankAccountNumber($value);

    /**
     * Generate the check digits for a given IBAN number
     *
     * @param $value
     * @param $countryCode
     * @return int
     */
    protected function generateCheckDigits($value, $countryCode)
    {
        $value = $value . $countryCode;
        $value = preg_replace_callback(
            '~[A-Z]~',
            function ($matches) {
                return $this->getCharacterValue($matches[0]);
            },
            $value
        );

        $value .= '00';
        $value = bcmod($value, "97");

        return str_pad((string)(98 - $value), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Get the default options for the generator
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        return new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_PAYMENT | Options::BANKACCOUNTTYPE_SAVINGS,
            Options::OPTION_VALID => true
        ]);
    }

    /**
     * Gets the character value as used for IBAN calculations
     *
     * @param $character
     * @return int
     */
    protected function getCharacterValue($character)
    {
        return ord($character) - 55;
    }

    /**
     * Retrieve the maximum length of a country's domestic bank account number
     *
     * @return array
     */
    protected function getAccountNumberLength()
    {
        return $this->countryConstraints['length'];
    }

    /**
     * Generate a random (domestic) bank account number
     *
     * @param $bankCode
     * @param $accountType
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function generateRandomAccountNumber($bankCode, $accountType)
    {
        if ($accountType == (Options::BANKACCOUNTTYPE_PAYMENT | Options::BANKACCOUNTTYPE_SAVINGS)) {
            $accountType = rand(Options::BANKACCOUNTTYPE_PAYMENT, Options::BANKACCOUNTTYPE_SAVINGS);
        }

        if ($accountType == Options::BANKACCOUNTTYPE_PAYMENT) {
            $length = $bankCode[self::CC_ACCOUNTNUMBER_PAYMENT_LENGTH];
        } elseif ($accountType == Options::BANKACCOUNTTYPE_SAVINGS) {
            $length = $bankCode[self::CC_ACCOUNTNUMBER_SAVINGS_LENGTH];
        } else {
            throw new \InvalidArgumentException('Invalid account type provided');
        }

        return (string)rand((int)str_pad('1', $length, '0'), (int)str_pad('9', $length, '0'));
    }
}
