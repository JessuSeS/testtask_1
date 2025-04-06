<?php

namespace App\enum;

enum ComparisonOperatorEnum: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case OVER = '>';
    case LESS = '<';

    public static function fromString(string $operator): self
    {
        return match ($operator) {
            'equal' => self::EQUAL,
            'not_equal' => self::NOT_EQUAL,
            'over' => self::OVER,
            'less' => self::LESS,
            default => throw new \InvalidArgumentException("Invalid operator: $operator"),
        };
    }
}
