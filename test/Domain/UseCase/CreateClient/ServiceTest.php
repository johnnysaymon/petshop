<?php

declare(strict_types=1);

namespace App\Tests\Domain\UseCase\CreateClient;

use App\Domain\Repository\ClientRepository;
use App\Domain\UseCase\CreateClient\DataInput;
use App\Domain\UseCase\CreateClient\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    private Service $service;

    protected function setUp(): void
    {
        $clientRepositoryMock = $this->createStub(ClientRepository::class);
        $clientRepositoryMock->method('store');

        $this->service = new Service($clientRepositoryMock);
    }

    public function testSuccess(): void
    {
        $dataInput = new DataInput(
            name: 'João Silva',
            phone: '8812341234'
        );

        $output = $this->service->run($dataInput);

        $this->assertTrue($output->status());
    }

    public function testErrorNameInvalid(): void
    {
        $dataInput = new DataInput(
            name: 'J',
            phone: '8812341234'
        );

        $output = $this->service->run($dataInput);

        $this->assertFalse($output->status());
        $this->assertFalse($output->statusName());
        $this->assertTrue($output->statusPhone());
        $this->assertEquals(Service::ERROR_INVALID, $output->errorNameCode);
    }

    public function testErrorNameEmpty(): void
    {
        $dataInput = new DataInput(
            name: '',
            phone: '8812341234'
        );

        $output = $this->service->run($dataInput);

        $this->assertFalse($output->status());
        $this->assertFalse($output->statusName());
        $this->assertEquals(Service::ERROR_EMPTY, $output->errorNameCode);
    }

    public function testErrorPhoneInvalid(): void
    {
        $dataInput = new DataInput(
            name: 'João Silva',
            phone: '881234123'
        );

        $output = $this->service->run($dataInput);

        $this->assertFalse($output->status());
        $this->assertTrue($output->statusName());
        $this->assertFalse($output->statusPhone());
        $this->assertEquals(Service::ERROR_INVALID, $output->errorPhoneCode);
    }

    public function testErrorPhoneEmpty(): void
    {
        $dataInput = new DataInput(
            name: 'João Silva',
            phone: ''
        );

        $output = $this->service->run($dataInput);

        $this->assertFalse($output->status());
        $this->assertFalse($output->statusPhone());
        $this->assertEquals(Service::ERROR_EMPTY, $output->errorPhoneCode);
    }
}
