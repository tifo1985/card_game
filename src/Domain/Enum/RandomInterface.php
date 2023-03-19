<?php

declare(strict_types=1);

namespace App\Domain\Enum;

interface RandomInterface
{
    public static function random();

    public static function randomOrder(): array;
}
