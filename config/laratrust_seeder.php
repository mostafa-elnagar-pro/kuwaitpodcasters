<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'home' => 'r',
            'admins' => 'c,r,u,d',
            'roles' => 'c,r,u,d',
            'permissions' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'podcasters' => 'c,r,u,d',
            'channels' => 'c,r,u,d',
            'seasons' => 'c,r,u,d',
            'podcasts' => 'r,u,d',
            'articles'=> 'c,r,u,d',
            'books' => 'c,r,u,d',
            'exclusive-episodes' => 'c,r,u,d',
            'countries' => 'c,r,d',
            'categories' => 'c,r,u,d',
            'languages' => 'c,r,u,d',
            'sliders' => 'c,r,d',
            'keywords' => 'c,r,u,d',
            'settings' => 'c,r,u,d',
            'feedbacks' => 'r,d',
            'app_rates' => 'r,d'
        ],
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
