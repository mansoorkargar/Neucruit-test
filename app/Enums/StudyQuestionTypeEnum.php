<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class StudyQuestionTypeEnum
 * @package App\Enums
 */
class StudyQuestionTypeEnum extends Enum
{
    /**
     * @const string
     */
    public const TEXT = 'TEXT';

    /**
     * @const string
     */
    public const TEXT_MULTIPLE_ROWS = 'TEXT_MULTIPLE_ROWS';

    /**
     * @const string
     */
    public const NUMBER = 'NUMBER';

    /**
     * @const string
     */
    public const DROPDOWN = 'DROPDOWN';

    /**
     * @const string
     */
    public const CHECKBOX = 'CHECKBOX';

    /**
     * @const string
     */
    public const RADIOBUTTON = 'RADIOBUTTON';

    /**
     * @const string
     */
    public const DATE = 'DATE';

    /**
     * @const string
     */
    public const BIRTHDATE = 'BIRTHDATE';

    /**
     * @const string
     */
    public const GENDER = 'GENDER';

    /**
     * @const string
     */
    public const ETHNICITY = 'ETHNICITY';

    /**
     * @const string
     */
    public const ADDRESS = 'ADDRESS';

    /**
     * @const string
     */
    public const SEPARATOR = 'SEPARATOR';

    /**
     * @const string
     */
    public const EMAIL = 'EMAIL';
}
