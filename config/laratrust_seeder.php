<?php

return [
    'role_structure' => [
        'superadmin' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u',
            'project' => 'c,r,u,d',
            'company' => 'c,r,u,d'
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'company' => 'c,r,u,d',
            'project' => 'c,r,u,d'
        ],
        'moderator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u',
            'company' => 'c,r,u,d',
            'project' => 'c,r,u,d'
        ],
        'company' => [
            'profile' => 'r,u',
            'company' => 'r,u',
            'project' => 'c,r,u,d',
            'review' => 'c,r'
        ],
        'user' => [
            'profile' => 'r,u',
            'company' => 'c,r,u',
            'review' => 'c,r'
        ],
    ],
    'permission_structure' => [],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
