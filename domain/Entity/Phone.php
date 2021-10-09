<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use InvalidArgumentException;
use Stringable;

final class Phone implements Stringable
{
    private const PATTERN_PHONE = '/(\d{2})[^\d]*(\d{4,5})[^\d]*(\d{4})[^\d]*/';

    private string $ddd;
    private string $prefix;
    private string $number;

    public function __construct(string $ddd, string $prefix, string $number)
    {
        $this->ddd = $ddd;
        $this->prefix = $prefix;
        $this->number = $number;
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function createFromString(string $value): Phone
    {
        $status = preg_match(self::PATTERN_PHONE, $value, $matches);

        if (! $status) {
            throw new InvalidArgumentException('phone-number-invalid', 1);
        }

        [$ddd, $prefix, $number] = array_slice($matches, 1);

        return new Phone($ddd, $prefix, $number);
    }

    public static function isValid(string $value): bool
    {
        return preg_match(self::PATTERN_PHONE, $value) === 1;
    }

    public function getFormated(): string
    {
        return "({$this->ddd}) {$this->prefix}-{$this->number}";
    }

    public function getDdd(): string
    {
        return $this->ddd;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getValue(): string
    {
        return $this->ddd.$this->prefix.$this->number;
    }

    public function __toString(): string
    {
        return $this->getFormated();
    }
}
