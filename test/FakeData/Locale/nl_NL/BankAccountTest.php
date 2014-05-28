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
namespace unit;

use Enrise\FakeData\Locale\nl_NL\BankAccount;
use Enrise\FakeData\Options;

class BankAccountTest extends \PHPUnit_Framework_TestCase
{
    public function testBankAccountPattern()
    {
        $generator = new BankAccount();

        $optionsPayment = new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_PAYMENT
        ]);
        $optionsSavings = new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_SAVINGS
        ]);

        // Since we are testing random data we must try our luck more than once
        for ($i = 0; $i < 10; $i++) {
            $this->assertEquals(9, strlen($generator->generate($optionsPayment)));
            $this->assertEquals(10, strlen($generator->generate($optionsSavings)));

            $this->assertRegExp('~[1-9][0-9]{8}~', $generator->generate($optionsPayment));
            $this->assertRegExp('~[1-9][0-9]{9}~', $generator->generate($optionsSavings));
        }
    }
} 
