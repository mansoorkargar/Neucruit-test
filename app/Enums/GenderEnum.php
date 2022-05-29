<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class GenderEnum
 * @package App\Enums
 */
class GenderEnum extends Enum
{
    /**
     * @const int
     */
    public const FEMALE = 1;

    /**
     * @const int
     */
    public const MALE = 2;

    /**
     * @const int
     */
    public const OTHER = 3;
}
