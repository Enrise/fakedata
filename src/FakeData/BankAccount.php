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
namespace Enrise\FakeData;

abstract class BankAccount
{
    /**
     * Test whether the given account number is valid according to the localized verification
     *
     * @param $value
     * @return mixed
     */
    abstract protected function isValidBankAccountNumber($value);

    /**
     * Generate a random account number based on the given account type
     *
     * @param $accountType
     * @return string
     */
    abstract protected function generateRandomAccountNumber($accountType);

    /**
     * Generate a random bank account number
     *
     * @param Options $options
     * @return string The bank account number
     */
    public function generate(Options $options = null)
    {
        if ($options == null) {
            $options = $this->getDefaultOptions();
        } else {
            $options = $this->getDefaultOptions()->merge($options);
        }

        $accountType = $options[Options::OPTION_BANKACCOUNTTYPE];
        $valid = $options[Options::OPTION_VALID];

        do {
            $bankAccountNumber = $this->generateRandomAccountNumber($accountType);
        } while ($this->isValidBankAccountNumber($bankAccountNumber) != $valid);

        return $bankAccountNumber;
    }

    /**
     * Get the default options for this generator
     *
     * @return Options
     */
    public function getDefaultOptions()
    {
        return new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_PAYMENT | Options::BANKACCOUNTTYPE_SAVINGS,
            Options::OPTION_VALID => true
        ]);
    }
}
