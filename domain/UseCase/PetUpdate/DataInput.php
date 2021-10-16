<?php

declare(strict_types=1);

namespace App\Domain\UseCase\PetUpdate;

use App\Domain\UseCase\PetSave\DataInput as DataInputSave;

final class DataInput extends DataInputSave
{
    public static function createFromArray(array $data): DataInput
    {
        $dataInput = new DataInput();
        DataInputSave::feed($dataInput, $data);
        return $dataInput;
    }
}
