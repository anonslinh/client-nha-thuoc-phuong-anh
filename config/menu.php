<?php

return [
    [
        'name' => 'Thống kê',
        'icon' => 'solar:layers-line-duotone',
        'submenu' => [
            [
                'name' => 'Tổng quan',
                'icon' => 'solar:atom-line-duotone',
                'route' => 'index'
            ]
        ]
    ],
  [
      'name' => 'Quà tặng',
      'icon' => 'solar:gift-broken',
      'submenu' => [
          [
              'name' => 'Danh sách',
              'icon' => 'solar:atom-line-duotone',
              'route' => 'gift.index'
          ],
          [
              'name' => 'KH đổi quà tặng',
              'icon' => 'solar:chart-line-duotone',
              'route' => 'customer.exchange-gift'
          ]
      ]
  ],
    [
      'name' => 'Khách hàng',
      'icon' => 'solar:bill-list-linear',
        'submenu' => [
            [
                'name' => 'Danh sách',
                'icon' => 'solar:sticker-smile-circle-2-line-duotone',
                'route' => 'customer'
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
                'name' => 'KH đổi voucher',
                'icon' => 'solar:repeat-one-minimalistic-bold-duotone',
                'route' => 'voucher.customer'
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
        'name' => 'Loyalty',
        'icon' => 'solar:notes-line-duotone',
        'submenu' => [
            [
                'name' => 'Cài đặt banner',
                'route' => 'banner.list-data',
                'icon' => 'solar:notes-line-duotone'
            ],
            [
                'name' => 'Cài đặt chương trình',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'program.list-data'
            ],
            [
                'name' => 'Cài đặt khuyến mại',
                'icon' => 'solar:tablet-line-duotone',
                'route' => 'promotion.list-data'
            ]
        ]
    ],
    [
        'name' => 'Cài đặt',
        'icon' => 'solar:settings-linear',
        'submenu' => [
            [
                'name' => 'Hạng thẻ',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'rank.index'
            ],
            [
                'name' => 'Đồng bộ nhân viên',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'config.employees'
            ],
            [
                'name' => 'Đồng bộ cửa hàng',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'config.branches'
            ],
            [
                'name' => 'Liên hệ & phản hồi',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'config.contacts'
            ],
            [
                'name' => 'Slogan',
                'icon' => 'solar:gallery-bold-duotone',
                'route' => 'config.slogan'
            ]
        ]
    ]
];
