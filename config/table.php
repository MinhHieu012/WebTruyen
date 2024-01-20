<?php
return [
    'default_paginate' => 20,
    'option_paginate'  => [20, 30, 50, 100, 200, 500],
    'pages'            => [
        'store-list' => [
            'headers'       => [
                'stt'          => 'STT',
                'code'         => 'Mã',
                'name_address' => 'Tên',
                'locality_tdv' => 'Địa bàn',
                'address'      => 'Địa chỉ',
                'customStatus' => 'Trạng thái',
                'features'     => 'Thao tác'
            ],
            'customColumns' => [
                'customStatus',
                'features',
                'tdv',
            ],
            'sortColumn'    => [
                'name',
                'code',
            ],
            'centerColumn'  => [
                'stt',
                'code',
                'customStatus',
                'features',
            ],
            'styleCss'      => [
                'tdv' => 'width: 150px'
            ]
        ],
    ],
];
