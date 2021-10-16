<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Phone;
use PHPUnit\Framework\TestCase;

class PhoneTest extends TestCase
{
    public function testCreateFromString(): void
    {
        $phoneNumber = '88123451234';
        $phone = Phone::createFromString($phoneNumber);
        $this->assertEquals($phoneNumber, $phone->getValue());
    }

    public function testGetPrefix(): void
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($prefix, $phone->getPrefix());
    }

    public function testIsValid(): void
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

    public function testGetDdd(): void
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($ddd, $phone->getDdd());
    }

    public function testGetValue(): void
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($ddd.$prefix.$number, $phone->getValue());
    }

    public function testGetNumber(): void
    {
        $ddd = '88';
        $prefix = '12345';
        $number = '9876';
        $phone = new Phone($ddd, $prefix, $number);

        $this->assertEquals($number, $phone->getNumber());
    }

    public function testGetFormated(): void
    {
        $phone = new Phone('88', '1234', '5678');

        $this->assertEquals('(88) 1234-5678', $phone->getFormated());
    }

    public static function getPhone(): Phone
    {
        $data = self::getData();

        return new Phone(
            ddd: $data->ddd,
            prefix: $data->prefix,
            number: $data->number
        );
    }

    public static function getData(): Object
    {
        return (object) [
            'ddd' => '88',
            'prefix' => '1234',
            'number' => '5678',
        ];
    }
}
