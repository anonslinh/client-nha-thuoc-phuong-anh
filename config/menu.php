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
                'route' => 'customer.exchange-voucher'
            ],
            [
                'name' => 'Khách hàng',
                'icon' => 'solar:bill-list-linear',
                'route' => 'customer'
            ],
            [
                'name' => 'Đánh hoá đơn',
                'icon' => 'solar:star-fall-minimalistic-2-line-duotone',
                'route' => 'employees.ratings-invoice'
            ],
            [
                'name' => 'Xuất hoá đơn',
                'icon' => 'solar:bill-list-linear',
                'route' => 'invoices-request.index'
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
        'name' => 'Mua là có quà',
        'icon' => 'solar:gift-bold',
        'submenu' => [
            [
                'name' => 'Danh sách quà tặng',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.list-gift'
            ],
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
                'name' => 'Lịch sử đổi quà',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.history-exchange-gift'
            ],
            [
                'name' => 'KH mua sản phẩm',
                'icon' => 'solar:waterdrops-line-duotone',
                'route' => 'events.cart'
            ]
        ]
    ],
    [
        'name' => 'Vòng quay may mắn',
        'icon' => 'solar:restart-broken',
        'submenu' => [
            [
                'name' => 'Cài đặt',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.setting'
            ],
            [
                'name' => 'Quà tặng',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.gift'
            ],
            [
                'name' => 'Lịch sử đổi quà',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.history-exchange-gift'
            ],
            [
                'name' => 'Quà tặng Như Anh',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.sub-gift'
            ],
            [
                'name' => 'Vòng quay checkin',
                'icon' => null,
                'route' => null,
                'type' => 'title'
            ],
            [
                'name' => 'DS quà tặng',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.gift_checkin.index'
            ],
            [
                'name' => 'Tạo quà tặng',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.gift_checkin.create'
            ],
            [
                'name' => 'Lịch sử đổi quà',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'rotation.gift_checkin.exchange-gift'
            ],
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
            ],
            [
                'name' => 'Cài đặt đánh giá',
                'icon' => 'solar:star-fall-minimalistic-2-line-duotone',
                'route' => 'config.setting-point-order-review'
            ],
            [
                'name' => 'Giấy chứng nhận',
                'icon' => 'solar:document-text-line-duotone',
                'route' => 'certificates.index'
            ],
            [
                'name' => 'AI Tự động',
                'icon' => 'solar:atom-line-duotone',
                'route' => 'setting-automatic.index-setting-email'
            ],
            [
                'name' => 'Cài đặt chung',
                'icon' => 'solar:settings-linear',
                'route' => 'config.setting-global'
            ],
            [
                'name' => 'KIOTVIET',
                'icon' => 'solar:settings-linear',
                'route' => 'config.index-account-branches'
            ]
        ]
    ]
];
