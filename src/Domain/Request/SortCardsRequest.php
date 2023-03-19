<?php

declare(strict_types=1);

namespace App\Domain\Request;

final class SortCardsRequest
{
    public function __construct(private readonly array $options)
    {
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
