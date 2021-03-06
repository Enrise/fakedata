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

use Enrise\FakeData\Locale\nl_NL\Iban;
use Enrise\FakeData\Options;

class IbanTest extends \PHPUnit_Framework_TestCase
{
    public function testNLIbanPattern()
    {
        $generator = new Iban();

        $this->assertEquals(18, strlen($generator->generate()));
        $this->assertRegExp('~NL[0-9]{2}[A-Z]{4}[0-9]{10}~', $generator->generate());
    }

    public function testNLIbanOnlyPayment()
    {
        $generator = new Iban();

        $options = new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_PAYMENT
        ]);

        for ($i = 0; $i < 10; $i++) {
            $generate = $generator->generate($options);
            $this->assertEquals(18, strlen($generate));
            $this->assertRegExp('~NL[0-9]{2}[A-Z]{4}((0[1-9][0-9]{8})|[0]{3}[1-9][0-9]{6})~', $generate);
        }
    }

    public function testNLIbanOnlySavings()
    {
        $generator = new Iban();

        $options = new Options([
            Options::OPTION_BANKACCOUNTTYPE => Options::BANKACCOUNTTYPE_SAVINGS
        ]);

        for ($i = 0; $i < 10; $i++) {
            $generate = $generator->generate($options);
            $this->assertEquals(18, strlen($generate));
            $this->assertRegExp('~NL[0-9]{2}[A-Z]{4}(([1-9][0-9]{9})|[0]{2,3}[1-9][0-9]{6,7})~', $generate);
        }
    }

    public function testWithDefaultOptions()
    {
        $generator = new Iban();
        $this->assertNotEmpty($generator->generate());
    }
}
