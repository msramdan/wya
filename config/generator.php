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

    /**
     * It will used for generator to manage and showing menus on sidebar views.
     *
     * Example:
     * [
     *   'header' => 'Main',
     *
     *   // All permissions in menus[] and submenus[]
     *   'permissions' => ['test view'],
     *
     *   menus' => [
     *       [
     *          'title' => 'Main Data',
     *          'icon' => '<i class="bi bi-collection-fill"></i>',
     *          'route' => null,
     *
     *          // permission always null when isset submenus
     *          'permission' => null,
     *
     *          // All permissions on submenus[] and will empty[] when submenus equals to []
     *          'permissions' => ['test view'],
     *
     *          'submenus' => [
     *                 [
     *                     'title' => 'Tests',
     *                     'route' => '/tests',
     *                     'permission' => 'test view'
     *                  ]
     *               ],
     *           ],
     *       ],
     *  ],
     *
     * This code below always changes when you use a generator and maybe you must lint or format the code.
     */
    'sidebars' => [
        [
            'header' => 'WorkOrder',
            'permissions' => [
                'work order view'
            ],
            'menus' => [
                [
                    'title' => 'Work Order',
                    'icon' => '<i class="mdi mdi-book-multiple"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'work order view',
                        'work order approval',
                        'work order process'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Work Orders Submission',
                            'route' => '/work-orders',
                            'permission' => 'work order view'
                        ],
                        [
                            'title' => 'Work Orders Approval',
                            'route' => '/work-order-approvals',
                            'permission' => 'work order approval'
                        ],
                        [
                            'title' => 'Work Order Processes',
                            'route' => '/work-order-processes',
                            'permission' => 'work order process'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Inventory',
            'permissions' => [
                'sparepart view',
                'nomenklatur view',
                'equipment view'
            ],
            'menus' => [
                [
                    'title' => 'Inventory Data',
                    'icon' => '<i class="mdi mdi-cube"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'sparepart view',
                        'nomenklatur view',
                        'equipment view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Equipments',
                            'route' => '/equipment',
                            'permission' => 'equipment view'
                        ],
                        [
                            'title' => 'Spareparts',
                            'route' => '/spareparts',
                            'permission' => 'sparepart view'
                        ],
                        [
                            'title' => 'Reference Nomeklatur',
                            'route' => '/nomenklaturs',
                            'permission' => 'nomenklatur view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Employee',
            'permissions' => [
                'department view',
                'position view',
                'employee type view',
                'employee view'
            ],
            'menus' => [
                [
                    'title' => 'Employee Data',
                    'icon' => '<i class="mdi mdi-account-multiple"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'department view',
                        'position view',
                        'employee type view',
                        'employee view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Employees',
                            'route' => '/employees',
                            'permission' => 'employee view'
                        ],
                        [
                            'title' => 'Departments',
                            'route' => '/departments',
                            'permission' => 'department view'
                        ],
                        [
                            'title' => 'Positions',
                            'route' => '/positions',
                            'permission' => 'position view'
                        ],
                        [
                            'title' => 'Employee Types',
                            'route' => '/employee-types',
                            'permission' => 'employee type view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Vendor',
            'permissions' => [
                'category vendor view',
                'vendor view'
            ],
            'menus' => [
                [
                    'title' => 'Vendor Data',
                    'icon' => '<i class="fa fa-address-book"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'category vendor view',
                        'vendor view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Vendors',
                            'route' => '/vendors',
                            'permission' => 'vendor view'
                        ],
                        [
                            'title' => 'Category Vendors',
                            'route' => '/category-vendors',
                            'permission' => 'category vendor view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Main',
            'permissions' => [
                'unit item view',
                'equipment location view',
                'equipment category view',
                'accessories type view'
            ],
            'menus' => [
                [
                    'title' => 'Main Data',
                    'icon' => '<i class="mdi mdi-format-list-bulleted"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'unit item view',
                        'equipment location view',
                        'equipment category view',
                        'accessories type view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Unit Items',
                            'route' => '/unit-items',
                            'permission' => 'unit item view'
                        ],
                        [
                            'title' => 'Equipment Locations',
                            'route' => '/equipment-locations',
                            'permission' => 'equipment location view'
                        ],
                        [
                            'title' => 'Equipment Categories',
                            'route' => '/equipment-categories',
                            'permission' => 'equipment category view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Region',
            'permissions' => [
                'province view',
                'kabkot view',
                'kecamatan view',
                'kelurahan view'
            ],
            'menus' => [
                [
                    'title' => 'Region Data',
                    'icon' => '<i class="mdi mdi-google-maps"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'province view',
                        'kabkot view',
                        'kecamatan view',
                        'kelurahan view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Provinces',
                            'route' => '/provinces',
                            'permission' => 'province view'
                        ],
                        [
                            'title' => 'Kabupaten Kota',
                            'route' => '/kabkots',
                            'permission' => 'kabkot view'
                        ],
                        [
                            'title' => 'Kecamatan',
                            'route' => '/kecamatans',
                            'permission' => 'kecamatan view'
                        ],
                        [
                            'title' => 'Kelurahan',
                            'route' => '/kelurahans',
                            'permission' => 'kelurahan view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Utilities',
            'permissions' => [
                'setting view',
                'role & permission view',
                'user view',
                'setting app view'
            ],
            'menus' => [
                [
                    'title' => 'Utilities',
                    'icon' => '<i data-feather="settings"></i>',
                    'route' => null,
                    'permission' => null,
                    'permissions' => [
                        'setting view',
                        'role & permission view',
                        'user view',
                        'setting app view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Settings App',
                            'route' => '/settings',
                            'permission' => 'setting view'
                        ],
                        [
                            'title' => 'Users',
                            'route' => '/users',
                            'permission' => 'user view'
                        ],
                        [
                            'title' => 'Roles & permissions',
                            'route' => '/roles',
                            'permission' => 'role & permission view'
                        ],
                        [
                            'title' => 'Setting Apps',
                            'route' => '/setting-apps',
                            'permission' => 'setting app view'
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Hospitals',
            'permissions' => [
                'hospital view'
            ],
            'menus' => [
                [
                    'title' => 'Hospitals',
                    'icon' => '<i class="fa fa-bank"></i>',
                    'route' => '/hospitals',
                    'permission' => 'hospital view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ]
    ]
];
