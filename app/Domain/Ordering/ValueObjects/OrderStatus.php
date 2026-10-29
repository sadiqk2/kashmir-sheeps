<?php

namespace App\Domain\Ordering\ValueObjects;

enum OrderStatus: string
{
    case CONFIRMED = 'Order Confirmed';
    case HEALTH_CLEARED = 'Veterinary Health Cleared';
    case IN_TRANSIT = 'In Transit';
    case DELIVERED = 'Delivered';
    case CANCELLED = 'Cancelled';

    public function next(): ?self
    {
        return match ($this) {
            self::CONFIRMED => self::HEALTH_CLEARED,
            self::HEALTH_CLEARED => self::IN_TRANSIT,
            self::IN_TRANSIT => self::DELIVERED,
            default => null,
        };
    }

    public function isCancellable(): bool
    {
        return $this !== self::DELIVERED && $this !== self::CANCELLED;
    }
}
