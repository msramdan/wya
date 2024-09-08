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
            'header' => 'Hospitals',
            'permissions' => [
                'hospital view'
            ],
            'menus' => [
                [
                    'title' => 'Rumah Sakit',
                    'icon' => '<i class="fa fa-hospital"></i>',
                    'route' => 'hospitals',
                    'permission' => 'hospital view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
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
                    'uri' => [
                        'work-orders*',
                        'work-order-approvals*',
                        'work-order-processes*'
                    ],
                    'permissions' => [
                        'work order view', 'work order approval', 'work order process'
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
                            'permission' => 'work order approval',
                        ],
                        [
                            'title' => 'Work Order Processes',
                            'route' => '/work-order-processes',
                            'permission' => 'work order process',
                        ]
                    ]
                ]
            ]
        ],
        [
            'header' => 'Loans',
            'permissions' => [
                'loan view'
            ],
            'menus' => [
                [
                    'title' => 'Peminjaman Alat',
                    'icon' => '<i class="mdi mdi-book"></i>',
                    'route' => '/loans',
                    'permission' => 'loan view',
                    'permissions' => [],
                    'submenus' => []
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
                    'title' => 'Data Inventaris',
                    'icon' => '<i class="mdi mdi-cube"></i>',
                    'route' => null,
                    'uri' => [
                        'equipment.index',
                        'equipment.create',
                        'equipment.edit',
                        'spareparts*',
                        'nomenklaturs*'
                    ],
                    'permissions' => [
                        'sparepart view',
                        'nomenklatur view',
                        'equipment view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Peralatan',
                            'route' => '/equipment',
                            'permission' => 'equipment view'
                        ],
                        [
                            'title' => 'Sparepart',
                            'route' => '/spareparts',
                            'permission' => 'sparepart view'
                        ],
                        [
                            'title' => 'Referensi Nomeklatur',
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
                    'permissions' => [
                        'department view',
                        'position view',
                        'employee type view',
                        'employee view'
                    ],
                    'uri' => [
                        'employees*',
                        'departments*',
                        'positions*',
                        'employee-types*'
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
                    'icon' => '<i class="fa fa-address-book" fa-xs></i>',
                    'route' => null,
                    'uri' => [
                        'vendors*',
                        'category-vendors*'
                    ],
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
                    'uri' => [
                        'unit-items*',
                        'equipment-locations*',
                        'equipment-categories*'
                    ],
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
        // [
        //     'header' => 'Region',
        //     'permissions' => [
        //         'province view',
        //         'kabkot view',
        //         'kecamatan view',
        //         'kelurahan view'
        //     ],
        //     'menus' => [
        //         [
        //             'title' => 'Region Data',
        //             'icon' => '<i class="mdi mdi-google-maps"></i>',
        //             'route' => null,
        //             'uri' => [
        //                 'provinces*',
        //                 'kabkots*',
        //                 'kecamatans*',
        //                 'kecamatans*'
        //             ],
        //             'permissions' => [
        //                 'province view',
        //                 'kabkot view',
        //                 'kecamatan view',
        //                 'kelurahan view'
        //             ],
        //             'submenus' => [
        //                 [
        //                     'title' => 'Provinces',
        //                     'route' => '/provinces',
        //                     'permission' => 'province view'
        //                 ],
        //                 [
        //                     'title' => 'Kabupaten Kota',
        //                     'route' => '/kabkots',
        //                     'permission' => 'kabkot view'
        //                 ],
        //                 [
        //                     'title' => 'Kecamatan',
        //                     'route' => '/kecamatans',
        //                     'permission' => 'kecamatan view'
        //                 ],
        //                 [
        //                     'title' => 'Kelurahan',
        //                     'route' => '/kelurahans',
        //                     'permission' => 'kelurahan view'
        //                 ]
        //             ]
        //         ]
        //     ]
        // ],
        [
            'header' => 'Utilities',
            'permissions' => [
                'setting view',
                'role & permission view',
                'user view',
                'setting app view',
                'activity log view',
                'backup database view',
            ],
            'menus' => [
                [
                    'title' => 'Utilities',
                    'icon' => '<i data-feather="settings"></i>',
                    'route' => null,
                    'uri' => [
                        'settings*',
                        'users*',
                        'roles*',
                        'setting-apps*',
                        'activity-log*',
                        'backup*'
                    ],
                    'permissions' => [
                        'setting view',
                        'role & permission view',
                        'user view',
                        'setting app view',
                        'activity log view',
                        'backup database view',
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
                        ],
                        [
                            'title' => 'Log Activity',
                            'route' => '/activity-log',
                            'permission' => 'activity log view'
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
