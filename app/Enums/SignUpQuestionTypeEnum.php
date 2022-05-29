<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class SignUpQuestionTypeEnum
 * @package App\Enums
 */
class SignUpQuestionTypeEnum extends Enum
{
    /**
     * @const int
     */
    public const TEXT = 1;

    /**
     * @const int
     */
    public const TEXT_MULTIPLE_ROWS = 2;

    /**
     * @const int
     */
    public const NUMBER = 3;

    /**
     * @const int
     */
    public const DROPDOWN = 4;

    /**
     * @const int
     */
    public const CHECKBOX = 5;

    /**
     * @const int
     */
    public const RADIOBUTTON = 6;
}
