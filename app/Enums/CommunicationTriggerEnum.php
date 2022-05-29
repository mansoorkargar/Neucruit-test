<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class CommunicationTriggerEnum
 * @package App\Enums
 */
class CommunicationTriggerEnum extends Enum
{
    /**
     * @const int
     */
    public const REGISTRATION = 1;

    /**
     * @const int
     */
    public const CONFIRMATION = 2;

    /**
     * @const int
     */
    public const IS_INELIGIBLE = 3;

    /**
     * @const int
     */
    public const COMPLETION = 4;

    /**
     * @const int
     */
    public const NOT_REACHABLE = 5;
}
