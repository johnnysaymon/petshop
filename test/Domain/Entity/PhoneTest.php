<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCreateFromString()
    {
        $phoneNumber = '88123451234';
        $phone = Phone::createFromString($phoneNumber);
        $this->assertEquals($phoneNumber, $phone->getValue());
    }

    public function testGetPrefix()
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($prefix, $phone->getPrefix());
    }

    public function testIsValid()
    {
        $this->assertTrue(Phone::isValid('88123451234'));
        $this->assertTrue(Phone::isValid('8812341234'));
        $this->assertFalse(Phone::isValid('881234123'));
        $this->assertFalse(Phone::isValid('881231234'));
        $this->assertFalse(Phone::isValid('812341234'));
        $this->assertFalse(Phone::isValid('12341234'));
        $this->assertFalse(Phone::isValid(''));
        $this->assertFalse(Phone::isValid('abc'));
    }

    public function testGetDdd()
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($ddd, $phone->getDdd());
    }

    public function testGetValue()
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($ddd.$prefix.$number, $phone->getValue());
    }

    public function testGetNumber()
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($number, $phone->getNumber());
    }

    public function testGetFormated()
    {
        $phone = new Phone('88', '1234', '5678');

        $this->assertEquals('(88) 1234-5678', $phone->getFormated());
    }
}
