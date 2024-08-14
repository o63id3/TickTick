<?php

namespace App\Enums;

enum TaskPriority: string
{
    case NONE = 'None';
    case LOW = 'Low';
    case MEDIUM = 'Medium';
    case HIGH = 'high';
}
