<?php

declare(strict_types=1);

namespace App\Domain\UseCase\ClientUpdate;

final class Output
{
    public string $errorNameCode = '';
    public string $errorPhoneCode = '';

    public function status(): bool
    {
        return $this->statusName()
            && $this->statusPhone();
    }

    public function statusName(): bool
    {
        return empty($this->errorNameCode);
    }

    public function statusPhone(): bool
    {
        return empty($this->errorPhoneCode);
    }
}
