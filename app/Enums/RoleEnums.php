<?php

namespace App\Enums;

class RoleEnums
{

    public const ROLE_ADMIN = 1;
    public const ROLE_EMPLOYEE = 2;
    public const ROLE_COMPANY = 3;
    public const ROLES = [
        self::ROLE_ADMIN => 'Администратор',
        self::ROLE_EMPLOYEE => 'Сотрудник',
        self::ROLE_COMPANY => 'Супер администратор'
    ];
}
