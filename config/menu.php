<?php

return [
    'default' => [
        [
            'group' => true,
            'name'  => 'Tổng quan',
            'route' => 'admin.dashboard.index',
        ],
        [
            'group' => true,
            'name'  => 'Chức năng',
            'child' => [
                [
                    'name'    => '01 Người dùng',
                    'icon'    => '<i data-feather="users"></i>',
                    'route'   => 'admin.users.index',
                    'perm'    => 'xem_danh_sach_nguoi_dung',
                    'pattern' => [
                        'admin/users/*',
                        'admin/users/*/*',
                        'admin/users/*/*/*',
                    ],
                    'child'   => [
                        [
                            'name'    => '0.1 Thêm người dùng',
                            'route'   => 'admin.users.create',
                            'display' => false
                        ],
                        [
                            'name'    => '0.1 Sửa người dùng',
                            'route'   => 'admin.users.edit',
                            'display' => false
                        ],
                    ]
                ],
                [
                    'name'  => '02 Vai trò & Quyền',
                    'icon'  => '<i data-feather="shield"></i>',
                    'child' => [
                        [
                            'name'    => '02.1 Vai trò',
                            'icon'    => '<i data-feather="shield"></i>',
                            'route'   => 'admin.roles.index',
                            'perm'    => 'xem_danh_sach_vai_tro',
                            'pattern' => [
                                'admin/roles/*',
                                'admin/roles/*/*',
                                'admin/roles/*/*/*',
                            ],
                            'child'   => [
                                [
                                    'name'    => '02.1 Thêm vai trò',
                                    'route'   => 'admin.roles.create',
                                    'display' => false
                                ],
                                [
                                    'name'    => '02.1 Sửa vai trò',
                                    'route'   => 'admin.roles.edit',
                                    'display' => false
                                ],
                            ]
                        ],
                        [
                            'name'    => '02.2 Quyền',
                            'icon'    => '<i data-feather="file-text"></i>',
                            'route'   => 'admin.permissions.index',
                            'perm'    => 'xem_danh_sach_quyen',
                            'pattern' => [
                                'admin/permissions/*',
                                'admin/permissions/*/*',
                                'admin/permissions/*/*/*'
                            ],
                            'child'   => [
                                [
                                    'name'    => '02.2 Sửa quyền',
                                    'route'   => 'admin.permissions.edit',
                                    'display' => false
                                ],
                            ]
                        ],
                    ],
                ],
               [
                   'name'    => '03 Crawl data',
                   'icon'    => '<i data-feather="settings"></i>',
                   'route'   => 'admin.crawl.index',
                   'perm'    => 'xem_crawl_data',
                   'pattern' => [
                       'admin/crawl/*',
                       'admin/crawl/*/*',
                       'admin/crawl/*/*/*',
                   ]
                ],
                [
                    'name'    => '04 Tác giả',
                    'icon'    => '<i data-feather="file-text"></i>',
                    'route'   => 'admin.author.index',
                    'perm'    => 'xem_author_data',
                    'pattern' => [
                        'admin/author/*',
                        'admin/author/*/*',
                        'admin/author/*/*/*',
                    ]
                ],
                [
                    'name'    => '05 Danh mục',
                    'icon'    => '<i data-feather="file-text"></i>',
                    'route'   => 'admin.category.index',
                    'perm'    => 'xem_category_data',
                    'pattern' => [
                        'admin/category/*',
                        'admin/category/*/*',
                        'admin/category/*/*/*',
                    ]
                ],
                [
                    'name'    => '06 Truyện',
                    'icon'    => '<i data-feather="file-text"></i>',
                    'route'   => 'admin.story.index',
                    'perm'    => 'xem_story_data',
                    'pattern' => [
                        'admin/story/*',
                        'admin/story/*/*',
                        'admin/story/*/*/*',
                    ]
                ],
                [
                    'name'    => '07 Rating',
                    'icon'    => '<i data-feather="file-text"></i>',
                    'route'   => 'admin.rating.index',
                    'perm'    => 'xem_rating_data',
                    'pattern' => [
                        'admin/rating/*',
                        'admin/rating/*/*',
                        'admin/rating/*/*/*',
                    ]
                ],
                [
                    'name'    => '08 Cấu hình',
                    'icon'    => '<i data-feather="settings"></i>',
                    'route'   => 'admin.display.index',
                    'perm'    => 'xem_display_data',
                    'pattern' => [
                        'admin/display/*',
                        'admin/display/*/*',
                        'admin/display/*/*/*',
                    ]
                ]
            ]
        ],
    ]
];
