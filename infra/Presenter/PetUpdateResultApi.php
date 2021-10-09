<?php

declare(strict_types=1);

namespace App\Infra\Presenter;

final class PetUpdateResultApi extends PetSaveResultApi
{
    protected function getCodeStatusSuccess(): int
    {
        return 204;
    }

    protected function generateResponseBodySuccess(): string
    {
        return '';
    }
}
