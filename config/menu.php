<?php

return [
    [
        'name' => 'Quản lý Website',
        'icon' => 'solar:layers-line-duotone',
        'submenu' => [
            [
                'name' => 'Tổng quan',
                'icon' => 'solar:widget-5-line-duotone', // Biểu tượng dashboard/ô vuông tổng quan
                'route' => 'index1'
            ],
            [
                'name' => 'Quản lý Header',
                'icon' => null,
                'route' => null,
                'type' => 'title'
            ],
            [
                'name' => 'Cấu hình Text SEO',
                'icon' => 'solar:globus-line-duotone', // Biểu tượng quả cầu (Web/SEO toàn cầu)
                'route' => 'catalog_v1.text_seo_header.index'
            ],
            [
                'name' => 'Cấu hình banner',
                'icon' => 'solar:gallery-wide-line-duotone', // Biểu tượng ảnh ngang (Banner/Slider)
                'route' => 'catalog_v1.banners.index'
            ],
            [
                'name' => 'Thông tin nổi bật',
                'icon' => 'solar:star-ring-line-duotone', // Biểu tượng ngôi sao nổi bật
                'route' => 'employees.employees'
            ],
            [
                'name' => 'Quản lý Footer',
                'icon' => null,
                'route' => null,
                'type' => 'title'
            ],
            [
                'name' => 'Quản lý danh sách cửa hàng',
                'icon' => 'solar:shop-2-line-duotone', // Biểu tượng cửa hàng/chi nhánh
                'route' => 'employees.employees'
            ],
            
            // Gợi ý cho các phần bạn đang comment (nếu mở lại)
            /*
            [
                'name' => 'Quản lý tích điểm đổi quà',
                'icon' => 'solar:medal-star-line-duotone', // Huy chương tích điểm
                'route' => 'customer'
            ],
            [
                'name' => 'Đổi quà',
                'icon' => 'solar:gift-line-duotone', // Hộp quà
                'route' => 'customer.exchange-gift'
            ],
            [
                'name' => 'Cài đặt lịch phòng',
                'icon' => 'solar:calendar-date-line-duotone', // Lịch trình
                'route' => 'booking.calendar.listData'
            ],
            [
                'name' => 'Đánh hoá đơn / Xuất hóa đơn',
                'icon' => 'solar:printer-minimalistic-line-duotone', // Máy in hóa đơn
                'route' => 'invoices-request.index'
            ],
            [
                'name' => 'Gửi đơn thuốc, hình ảnh',
                'icon' => 'solar:medical-mask-line-duotone', // Khẩu trang hoặc biểu tượng y tế
                'route' => 'pharmacy.prescription'
            ]
            */
        ]
    ],
    [
        'name' => 'Quản lý Đơn hàng',
        'icon' => 'solar:cart-3-line-duotone',
        'submenu' => [
            [
                'name' => 'Danh sách đơn hàng',
                'route' => 'catalog_v1.admin.order_v1.index',
                'icon' => 'solar:bill-list-line-duotone' // Phương án 1: Danh sách hóa đơn (Cực kỳ chuyên nghiệp)
            ],
            [
                'name' => 'Yêu cầu tư vấn',
                'icon' => null,
                'route' => null,
                'type' => 'title'
            ],
            [
                'name' => 'Danh sách yêu cầu',
                'icon' => 'solar:chat-round-dots-line-duotone', // Phương án 1: Bong bóng chat (Rất hợp cho tư vấn)
                'route' => 'catalog_v1.prescription_request_v1.index'
            ],
            // [
            //     'name' => 'Quản lý phòng',
            //     'icon' => 'solar:notes-line-duotone',
            //     'route' => 'rooms.listDataRooms'
            // ],
            // [
            //     'name' => 'Cài đặt thực đơn',
            //     'icon' => 'solar:file-text-line-duotone',
            //     'route' => 'menus.listDataMenus'
            // ],
            // [
            //     'name' => 'Cài đặt tiện ích',
            //     'icon' => 'solar:mask-happly-line-duotone',
            //     'route' => 'utilities.listDataUtilities'
            // ],
            // [
            //     'name' => 'Cài đặt voucher',
            //     'icon' => 'solar:palette-round-line-duotone',
            //     'route' => 'voucher.list-data'
            // ],
            // [
            //     'name' => 'Cài đặt quà tặng',
            //     'icon' => 'solar:gift-broken',
            //     'route' => 'gift.index'
            // ]
        ]
    ],
    [
    'name' => 'Quản lý admin',
    'icon' => 'solar:settings-minimalistic-line-duotone', // Thay Palette bằng Settings (chuẩn quản trị)
    'submenu' => [
        // --- TỪ KHÓA ---
        [
            'name' => 'Quản lý từ khóa',
            'icon' => null,
            'route' => null,
            'type' => 'title'
        ],
        [
            'name' => 'Cấu hình từ khóa',
            'icon' => 'solar:magnifer-line-duotone', // Icon kính lúp cho từ khóa tìm kiếm
            'route' => 'catalog_v1.search_keywords.index'
        ],

        // --- DANH MỤC TỔNG ---
        [
            'name' => 'Quản lý danh mục tổng',
            'icon' => null,
            'route' => null,
            'type' => 'title'
        ],
        [
            'name' => 'Danh mục tổng',
            'icon' => 'solar:layers-line-duotone', // Icon các lớp chồng lên nhau
            'route' => 'catalog_v1.main_categories.index'
        ],

        // --- DANH MỤC ---
        [
            'name' => 'Quản lý danh mục',
            'icon' => null,
            'route' => null,
            'type' => 'title'
        ],
        [
            'name' => 'Cấu hình Danh mục',
            'icon' => 'solar:list-arrow-down-line-duotone', // Icon danh sách có mũi tên phân cấp
            'route' => 'catalog_v1.categories.index'
        ],

        // --- THƯƠNG HIỆU ---
        [
            'name' => 'Quản lý thương hiệu',
            'icon' => null,
            'route' => null,
            'type' => 'title'
        ],
        [
            'name' => 'Quản lý thương hiệu',
            'icon' => 'solar:medal-ribbon-star-line-duotone', // Icon huy chương cho thương hiệu
            'route' => 'catalog_v1.trademarks.index'
        ],
        [
            'name' => 'Thương hiệu nổi bật',
            'icon' => 'solar:star-circle-line-duotone', // Ngôi sao cho thương hiệu nổi bật
            'route' => 'catalog_v1.favorite_trademarks.index'
        ],

        // --- SẢN PHẨM ---
        [
            'name' => 'Quản lý sản phẩm',
            'icon' => null,
            'route' => null,
            'type' => 'title'
        ],
        [
            'name' => 'Cấu hình sản phẩm',
            'icon' => 'solar:box-minimalistic-line-duotone', // Icon hộp hàng
            'route' => 'catalog_v1.products.index'
        ],
        [
            'name' => 'Quản lý flashsale',
            'icon' => 'solar:bolt-line-duotone', // Icon tia sét cho Flashsale
            'route' => 'catalog_v1.flashsales.index'
        ],
        [
            'name' => 'Sản phẩm bán chạy',
            'icon' => 'solar:fire-line-duotone', // Icon ngọn lửa cho sản phẩm Hot/Bán chạy
            'route' => 'catalog_v1.best_sellers.index'
        ],
        [
            'name' => 'Sản phẩm bệnh theo mùa',
            'icon' => 'solar:calendar-mark-line-duotone', // Icon lịch đánh dấu theo mùa
            'route' => 'catalog_v1.season_disease_categories.index'
        ],
    ]
],
    // [
    //     'name' => 'Vòng quay may mắn',
    //     'icon' => 'solar:restart-broken',
    //     'submenu' => [
    //         [
    //             'name' => 'Cài đặt',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.setting'
    //         ],
    //         [
    //             'name' => 'Quà tặng',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift'
    //         ],
    //         [
    //             'name' => 'Lịch sử đổi quà',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.history-exchange-gift'
    //         ],
    //         [
    //             'name' => 'Vòng quay checkin',
    //             'icon' => null,
    //             'route' => null,
    //             'type' => 'title'
    //         ],
    //         [
    //             'name' => 'Cài đặt',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift_checkin.setting'
    //         ],
    //         [
    //             'name' => 'DS quà tặng',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift_checkin.index'
    //         ],
    //         [
    //             'name' => 'Tạo quà tặng',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift_checkin.create'
    //         ],
    //         [
    //             'name' => 'Lịch sử đổi quà',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift_checkin.exchange-gift'
    //         ],
    //         [
    //             'name' => 'Khách hàng checkin',
    //             'icon' => 'solar:settings-line-duotone',
    //             'route' => 'rotation.gift_checkin.list-customer'
    //         ]
    //     ]
    // ],
    [
        'name' => 'Quản lý bài viết', // Đổi từ "Thông tin" sang "Bài viết" sẽ rõ nghĩa hơn
        'icon' => 'solar:pen-new-square-line-duotone', // Biểu tượng viết bài/sáng tạo nội dung
        'submenu' => [
            [
                'name' => 'Góc sức khỏe',
                'icon' => 'solar:heart-pulse-line-duotone', // Nhịp tim (Gợi ý sự sống, sức khỏe, sự tích cực)
                'route' => 'catalog_v1.health_corner.categories'
            ],
            [
                'name' => 'Bài viết về Bệnh',
                'icon' => 'solar:bacteria-line-duotone', // Vi khuẩn/Mầm bệnh (Phân biệt rõ với tin sức khỏe chung)
                'route' => 'catalog_v1.diseases.categories'
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
            ],
            [
                'name' => 'Tích điểm theo sản phẩm',
                'icon' => null,
                'route' => null,
                'type' => 'type_point',
            ],
            [
                'name' => 'Sản phẩm',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'config.list-product',
                'type_point' => 1
            ],
            [
                'name' => 'Lịch sử tích điểm',
                'icon' => 'solar:settings-line-duotone',
                'route' => 'config.history-point',
                'type_point' => 1
            ],
        ]
    ]
];
