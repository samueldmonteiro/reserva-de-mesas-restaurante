<?php

namespace App\Enum;

enum ReservationStatus: string
{
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
