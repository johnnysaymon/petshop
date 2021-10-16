<?php

declare(strict_types=1);

namespace App\Tests\Domain\Entity\Pet\Species\Dog;

use App\Domain\Entity\Pet\BreedName;
use App\Domain\Entity\Pet\Species\DogBreed;
use PHPUnit\Framework\TestCase;

class DogBreedTest extends TestCase
{
    public function testCreate(): void
    {
        $dogBread = $this->getDogBreed();
        $data = $this->getData();

        $this->assertEquals($data->name, $dogBread->getName()->getValue());
    }

    public static function getDogBreed(): DogBreed
    {
        $data = self::getData();

        return new DogBreed(
            name: new BreedName($data->name)
        );
    }

    public static function getData(): Object
    {
        return (object) [
            'name' => 'Buldogue'
        ];
    }
}
