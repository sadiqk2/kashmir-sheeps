<?php

namespace App\Domain\Livestock\ValueObjects;

use InvalidArgumentException;

readonly class Money
{
    public function __construct(
        public float $amount,
        public string $currency = 'INR'
    ) {
        if ($this->amount < 0) {
            throw new InvalidArgumentException('Money amount cannot be negative.');
        }
    }

    public static function from(float|int|string $amount, string $currency = 'INR'): self
    {
        return new self((float) $amount, $currency);
    }

    public function formatted(): string
    {
        return '₹' . number_format($this->amount, 2);
    }
}
