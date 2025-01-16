<?php

namespace App\Enum;

enum TableStatus: string
{
    case AVAILABLE = 'available';
    case RESERVED = 'reserved';
}
