<?php

namespace App\Enums;

class RoleEnum extends Enum
{
    /**
     * @const int
     */
    public const SUPERUSER = 1;

    /**
     * @const int
     */
    public const CLIENT = 2;

    /**
     * @const int
     */
    public const CLINICAL_STAFF = 3;
}
