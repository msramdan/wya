<?php

return [
    /**
     * If any input file(image) as default will used options below.
     */
    'image' => [
        /**
         * Path for store the image.
         *
         * avaiable options:
         * 1. public
         * 2. storage
         */
        'path' => 'storage',

        /**
         * Will used if image is nullable and default value is null.
         */
        'default' => 'https://via.placeholder.com/350?text=No+Image+Avaiable',

        /**
         * Crop the uploaded image using intervention image.
         */
        'crop' => true,

        /**
         * When set to true the uploaded image aspect ratio will still original.
         */
        'aspect_ratio' => true,

        /**
         * Crop image size.
         */
        'width' => 500,
        'height' => 500,
    ],

    'format' => [
        /**
         * Will used to first year on select, if any column type year.
         */
        'first_year' => 1900,

        /**
         * If any date column type will cast and display used this format, but for input date still will used Y-m-d format.
         *
         * another most common format:
         * - M d Y
         * - d F Y
         * - Y m d
         */
        'date' => 'd/m/Y',

        /**
         * If any input type month will cast and display used this format.
         */
        'month' => 'm/Y',

        /**
         * If any input type time will cast and display used this format.
         */
        'time' => 'H:i',

        /**
         * If any datetime column type or datetime-local on input, will cast and display used this format.
         */
        'datetime' => 'd/m/Y H:i',

        /**
         * Limit string on index view for any column type text or longtext.
         */
        'limit_text' => 100,
    ],

    'sidebars' => [
        [
            'header' => 'Utilities',
            'permissions' => [
                'role & permission view',
                'user view',
                'setting app view',
                'backup database view',
            ],
            'menus' => [
                [
                    'title' => 'Utilities',
                    'icon' => '<i data-feather="settings"></i>',
                    'route' => null,
                    'uri' => [
                        'users*',
                        'roles*',
                        'setting-apps*',
                        'activity-log*',
                        'backup*'
                    ],
                    'permissions' => [
                        'role & permission view',
                        'user view',
                        'setting app view',
                        'backup database view',
                    ],
                    'submenus' => [
                        [
                            'title' => 'Pengguna',
                            'route' => '/users',
                            'permission' => 'user view'
                        ],
                        [
                            'title' => 'Peran dan Izin Akses',
                            'route' => '/roles',
                            'permission' => 'role & permission view'
                        ],
                        [
                            'title' => 'Pengaturan Aplikasi',
                            'route' => '/setting-apps',
                            'permission' => 'setting app view'
                        ],
                        [
                            'title' => 'Backup Database',
                            'route' => '/backup',
                            'permission' => 'backup database view'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
