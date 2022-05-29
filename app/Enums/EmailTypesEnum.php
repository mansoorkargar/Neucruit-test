<?php


namespace App\Enums;

/**
 * Class EmailTypesEnum
 * @package App\Enums
 */
class EmailTypesEnum extends Enum
{
    /**
     * @const int
     */
    public const REGISTRATION = 1;

    /**
     * @const int
     */
    public const COMPLETING = 2;

    /**
     * @const int
     */
    public const IN_ELIGIBLE = 3;

    /**
     * @const int
     */
    public const NOT_REACHABLE = 4;

    /**
     * @const int
     */
    public const CONFIRMATION = 5;
}
