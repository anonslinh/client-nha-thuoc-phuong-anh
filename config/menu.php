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
            ],
            [
                'name' => 'Đánh giá nhân viên',
                'icon' => 'solar:star-fall-minimalistic-2-line-duotone',
                'route' => 'employees.employees'
            ],
            [
                'name' => 'Đổi quà',
                'icon' => 'solar:gift-broken',
                'route' => 'customer.exchange-gift'
            ],
            [
                'name' => 'Đổi voucher',
                'icon' => 'solar:palette-round-line-duotone',
                'route' => 'voucher.customer'
            ],
            [
                'name' => 'Khách hàng',
                'icon' => 'solar:bill-list-linear',
                'route' => 'customer'
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
//            [
//                'name' => 'Tạo sự kiện',
//                'icon' => 'solar:tag-horizontal-line-duotone',
//                'route' => 'events.create'
//            ],
            [
                'name' => 'Sản phẩm',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.list-product'
            ],
            [
                'name' => 'DS Khách Hàng',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.list-customer'
            ],
            [
                'name' => 'Lịch sử điểm',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.history-point'
            ],
            [
                'name' => 'Danh sách quà tặng',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.list-gift'
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
                'icon' => 'solar:gallery-bold-duotone'
            ],
            [
                'name' => 'Cài đặt chương trình',
                'icon' => 'solar:notes-line-duotone',
                'route' => 'program.list-data'
            ],
            [
                'name' => 'Cài đặt khuyến mại',
                'icon' => 'solar:file-text-line-duotone',
                'route' => 'promotion.list-data'
            ],
            [
                'name' => 'Cài đặt mini games',
                'icon' => 'solar:mask-happly-line-duotone',
                'route' => 'loyalty.mini-games'
            ],
            [
                'name' => 'Cài đặt voucher',
                'icon' => 'solar:palette-round-line-duotone',
                'route' => 'voucher.list-data'
            ],
            [
                'name' => 'Cài đặt quà tặng',
                'icon' => 'solar:gift-broken',
                'route' => 'gift.index'
            ]
        ]
    ],
    [
        'name' => 'Cài đặt',
        'icon' => 'solar:settings-linear',
        'submenu' => [
            [
                'name' => 'Hạng thẻ',
                'icon' => 'solar:calendar-mark-line-duotone',
                'route' => 'rank.index'
            ],
            [
                'name' => 'Đồng bộ nhân viên',
                'icon' => 'solar:shield-user-line-duotone',
                'route' => 'config.employees'
            ],
            [
                'name' => 'Đồng bộ cửa hàng',
                'icon' => 'solar:cart-3-line-duotone',
                'route' => 'config.branches'
            ],
            [
                'name' => 'Liên hệ & phản hồi',
                'icon' => 'solar:phone-line-duotone',
                'route' => 'config.contacts'
            ],
            [
                'name' => 'Slogan',
                'icon' => 'solar:document-text-line-duotone',
                'route' => 'config.slogan'
            ]
        ]
    ]
];
