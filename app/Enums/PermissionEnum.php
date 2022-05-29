<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class PermissionEnum
 * @package App\Enums
 */
class PermissionEnum extends Enum
{
    /**
     * @const string
     */
    public const USERS_MANAGE_USERS = 'manage-users';

    /**
     * @const string
     */
    public const ROLES_MANAGE_ROLES = 'manage-roles';

    /**
     * @const string
     */
    public const STUDIES_MANAGE_STUDIES = 'manage-studies';

    /**
     * @const string
     */
    public const STUDIES_MANAGE_EMAIL_TEMPLATES = 'manage-email-templates';
}
