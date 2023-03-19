<?php

declare(strict_types=1);

namespace App\Domain\Enum;

trait RandomTrait
{
    public static function random(): self
    {
        $enums = self::cases();

        return $enums[array_rand($enums)];
    }

    /** @return self[] */
    public static function randomOrder(): array
    {
        $enums = self::cases();
        shuffle($enums);

        return $enums;
    }
}
