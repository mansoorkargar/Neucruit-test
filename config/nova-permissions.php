<?php

use App\Enums\PermissionEnum;

return [
    /*
    |--------------------------------------------------------------------------
    | User model class
    |--------------------------------------------------------------------------
    */

    'user_model' => 'App\Models\User',

    /*
    |--------------------------------------------------------------------------
    | Nova User resource tool class
    |--------------------------------------------------------------------------
    */

    'user_resource' => 'App\Nova\User',

    /*
    |--------------------------------------------------------------------------
    | The group associated with the resource
    |--------------------------------------------------------------------------
    */

    'role_resource_group' => 'Other',

    /*
    |--------------------------------------------------------------------------
    | Database table names
    |--------------------------------------------------------------------------
    | When using the "HasRoles" trait from this package, we need to know which
    | table should be used to retrieve your roles. We have chosen a basic
    | default value but you may easily change it to any table you like.
    */

    'table_names' => [
        'roles' => 'roles',

        'role_permission' => 'role_permission',

        'role_user' => 'role_user',
        
        'users' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        PermissionEnum::USERS_MANAGE_USERS => [
            'display_name' => 'Manage users',
            'description'  => 'Can add, edit or delete users',
            'group'        => 'Users',
        ],

        PermissionEnum::ROLES_MANAGE_ROLES => [
            'display_name' => 'Manage roles',
            'description'  => 'Can add, edit or delet roles',
            'group'        => 'Roles',
        ],

        PermissionEnum::STUDIES_MANAGE_STUDIES => [
            'display_name' => 'Manage studies',
            'description'  => 'Can add, edit or delet studies',
            'group'        => 'Studies',
        ],

        PermissionEnum::STUDIES_MANAGE_EMAIL_TEMPLATES => [
            'display_name' => 'Manage email templaes',
            'description'  => 'Can manage the email templates',
            'group'        => 'Studies',
        ],
    ],
];
