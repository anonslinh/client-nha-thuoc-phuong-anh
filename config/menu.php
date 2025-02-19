<?php

return [
  [
      'name' => 'Quà tặng',
      'icon' => 'solar:layers-line-duotone',
      'submenu' => [
          [
              'name' => 'Danh sách',
              'icon' => 'solar:atom-line-duotone',
              'route' => 'index'
          ],
          [
              'name' => 'Khách hàng',
              'icon' => 'solar:chart-line-duotone',
              'route' => 'customer'
          ]
      ]
  ],
    [
        'name' => 'Banner',
        'icon' => 'solar:notes-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'route' => 'banner.list-data',
                'icon' => 'solar:notes-line-duotone'
            ]
        ]
    ],
    [
        'name' => 'Voucher',
        'icon' => 'solar:palette-round-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:archive-line-duotone',
                'route' => 'voucher.list-data'
            ],
            [
                'name' => 'KH sử dụng voucher',
                'icon' => 'solar:repeat-one-minimalistic-bold-duotone',
                'route' => 'voucher.customer'
            ]
        ]
    ],
    [
        'name' => 'Chương trình',
        'icon' => 'solar:tuning-square-2-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'program.list-data'
            ],
            [
                'name' => 'Tạo mới',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'program.create'
            ]
        ]
    ],
    [
        'name' => 'Khuyến mại',
        'icon' => 'solar:chart-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'promotion.list-data'
            ],
            [
                'name' => 'Tạo mới',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'promotion.create'
            ]
        ]
    ],
    [
        'name' => 'Sự kiện',
        'icon' => 'solar:widget-6-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.list-data'
            ],
            [
                'name' => 'Tạo sự kiện',
                'icon' => 'solar:tag-horizontal-line-duotone',
                'route' => 'events.create'
            ]
        ]
    ],
    [
        'name' => 'Hạng thành viên',
        'icon' => 'solar:lock-keyhole-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'rank.index'
            ]
        ]
    ]
];
