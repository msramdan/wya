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
                            'title' => 'Pengajuan Work Order',
                            'route' => '/work-orders',
                            'permission' => 'work order view'
                        ],
                        [
                            'title' => 'Persetujuan Work Order',
                            'route' => '/work-order-approvals',
                            'permission' => 'work order approval',
                        ],
                        [
                            'title' => 'Proses Work Order',
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
                    'title' => 'Data Karyawan',
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
                            'title' => 'Karyawan',
                            'route' => '/employees',
                            'permission' => 'employee view'
                        ],
                        [
                            'title' => 'Departemen',
                            'route' => '/departments',
                            'permission' => 'department view'
                        ],
                        [
                            'title' => 'Jabatan',
                            'route' => '/positions',
                            'permission' => 'position view'
                        ],
                        [
                            'title' => 'Jenis Karyawan',
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
                    'title' => 'Data Vendor',
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
                            'title' => 'Vendor',
                            'route' => '/vendors',
                            'permission' => 'vendor view'
                        ],
                        [
                            'title' => 'Kategori Vendor',
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
                    'title' => 'Data Utama',
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
                            'title' => 'Unit Item',
                            'route' => '/unit-items',
                            'permission' => 'unit item view'
                        ],
                        [
                            'title' => 'Lokasi Peralatan',
                            'route' => '/equipment-locations',
                            'permission' => 'equipment location view'
                        ],
                        [
                            'title' => 'Kategori Peralatan',
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
                            'title' => 'Log Aktifitas',
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
