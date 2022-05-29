<?php

declare(strict_types=1);

return [
    'gender_enum' => [
        'female' => 'Female',
        'male'   => 'Male',
        'other'  => 'Other',
    ],

    'study_status_enum' => [
        'created'             => 'Created',
        'in_progress'         => 'In Progress',
        'submitted'           => 'Submitted',
        'missing_information' => 'Missing Information',
        'completed'           => 'Completed',
    ],

    'study_type_enum' => [
        'physical' => 'Physical',
        'digital'  => 'Digital',
    ],

    'communication_trigger_enum' => [
        'registration'  => 'Registration',
        'completion'    => 'Completion',
        'confirmation'  => 'Confirmation',
        'is_ineligible' => 'Is ineligible',
        'not_reachable' => 'Not reachable',
    ],

    'role_enum' => [
        'client'         => 'Client',
        'clinical_staff' => 'Clinical Staff',
        'superuser'      => 'Superuser',
    ],

    'sign_up_question_type_enum' => [
        'text'               => 'Text',
        'text_multiple_rows' => 'Text (multiple rows, textarea)',
        'number'             => 'Number',
        'dropdown'           => 'Dropdown',
        'checkbox'           => 'Checkbox',
        'radiobutton'        => 'Radiobutton',
    ],

    'participant_status_enum' => [
        'booked'      => 'Booked',
        'sent'        => 'Sent',
        'in_progress' => 'In Progress',
        'booked'      => 'Complete',
    ],

    'study_question_type_enum' => [
        'text'               => 'Text',
        'text_multiple_rows' => 'Text Multiple Rows',
        'number'             => 'Number',
        'dropdown'           => 'Dropdown',
        'checkbox'           => 'Checkbox',
        'radiobutton'        => 'Radiobutton',
        'date'               => 'Date',
        'birthdate'          => 'Birthdate',
        'gender'             => 'Gender',
        'ethnicity'          => 'Ethnicity',
        'address'            => 'Address',
        'separator'          => 'Separator',
        'email'              => 'Email',
    ],
];