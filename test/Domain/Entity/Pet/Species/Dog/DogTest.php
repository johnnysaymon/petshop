<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity\Pet\Species\Dog;

use App\Domain\Entity\Client\Client;
use App\Domain\Entity\Pet\BreedName;
use App\Domain\Entity\Pet\PetAge;
use App\Domain\Entity\Pet\PetName;
use App\Domain\Entity\Pet\Species\Dog;
use App\Domain\Entity\Pet\Species\DogBreed;
use App\Domain\Entity\Uuid;
use App\Tests\Domain\Entity\Client\ClientTest;
use PHPUnit\Framework\TestCase;

class DogTest extends TestCase
{
    public function testCreate(): void
    {
        $dog = self::getDog();
        $data = self::getData();

        $this->assertEquals($data->id, $dog->getId()->getValue());
        $this->assertEquals($data->name, $dog->getName()->getValue());
        $this->assertEquals($data->age, $dog->getAge()->getValue());
        $this->assertInstanceOf(DogBreed::class, $dog->getBreed());
        $this->assertInstanceOf(Client::class, $dog->getOwner());
        $this->assertInstanceOf(Uuid::class, $dog->getId());
    }

    public function testGetSpeciesKey()
    {
        $dog = self::getDog();

        $this->assertEquals(Dog::SPECIES_KEY, $dog->getSpeciesKey());
    }

    public static function getDog(): Dog
    {
        $data = self::getData();

        return new Dog(
            name: new PetName($data->name),
            age: new PetAge($data->age),
            breed: DogBreedTest::getDogBreed(),
            owner: ClientTest::getClient(),
            id: new Uuid($data->id)
        );
    }

    public static function getData(): Object
    {
        return (object) [
            'id' => '48da9eb2-b416-4663-bd3d-33fd6f34c0af',
            'name' => 'Apolo',
            'age' => 2
        ];
    }
}
