<?php

namespace App\Enums;

enum UserRolesEnum: int
{
    case Customer = 3;
    case Staff = 2;
    case Manager = 1;

    public static function getNames(): array
    {
        return [
            self::Customer->value => 'Customer',
            self::Staff->value => 'Staff',
            self::Manager->value => 'Manager',
        ];
    }
}
