<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity\Client;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Client\ClientName;
use App\Domain\Entity\Phone;
use App\Domain\Entity\Uuid;
use App\Tests\Domain\Entity\PhoneTest;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testCreate()
    {
        $client = self::getClient();
        $data = self::getData();

        $this->assertEquals($data->name, $client->getName()->getValue());
        $this->assertInstanceOf(Uuid::class, $client->getId());
        $this->assertInstanceOf(Phone::class, $client->getPhone());
    }

    public static function getClient(): Client
    {
        $data = self::getData();

        return new Client(
            name: new ClientName($data->name),
            phone: PhoneTest::getPhone(),
            id: new Uuid()
        );
    }

    public static function getData(): Object
    {
        return (object) [
            'id' => '2f60b027-64b8-4d0a-a22e-a0404e14f294',
            'name' => 'João Silva'
        ];
    }
}
