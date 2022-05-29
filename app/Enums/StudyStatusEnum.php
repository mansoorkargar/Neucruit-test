<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class StudyStatusEnum
 * @package App\Enums
 */
class StudyStatusEnum extends Enum
{
    /**
     * @const int
     */
    public const CREATED = 1;

    /**
     * @const int
     */
    public const IN_PROGRESS = 2;

    /**
     * @const int
     */
    public const SUBMITTED = 3;

    /**
     * @const int
     */
    public const MISSING_INFORMATION = 4;

    /**
     * @const int
     */
    public const COMPLETED = 5;
}
