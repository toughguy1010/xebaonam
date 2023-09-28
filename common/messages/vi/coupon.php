<?php

/*
 * @hungtm
 */
return array(
    'name' => 'Tên chiến dịch khuyến mãi',
    'usage_limit' => 'Nhập số lần sử dụng của mã khuyến mãi',
    'no_limit' => 'Không giới hạn',
    'coupon_type' => 'Loại khuyến mãi',
    'coupon_value' => 'Giảm',
    'applies_to_resource' => 'Áp dụng cho',
    'minimum_order_amount' => 'Giá từ',
    'category_id' => 'Danh mục',
    'product_id' => 'Sản phẩm',
    'applies_one' => 'Áp dụng mã khuyến mãi', // 1 sản phẩm hay từng sản phẩm trong giỏ hàng 
    'released_date' => 'Bắt đầu khuyến mãi',
    'expired_date' => 'Hết hạn khuyến mãi',
    'import' => 'Tạo mã tự động hoặc nhập thủ công',
    'coupon_prefix' => 'Tiền tố mã giảm giá',
    'coupon_number' => 'Số lượng mã bạn muốn tạo ra',
    'code' => 'Mã giảm giá',
    'used' => 'Đã dùng',
    'manager_coupon_campaign' => 'Quản lý mã khuyến mãi',
    'create' => 'Tạo khuyến mãi',
    'update' => 'Cập nhật khuyến mãi',
    'fixed_amount' => 'VND', // coupon_type
    'percentage' => '% Giảm', // coupon_type
    'shipping' => 'Miến phí vận chuyển', // coupon_type
    'all' => 'Tất cả đơn hàng', // applies_to_resource
    'minimum_order_amount' => 'Giá trị đơn hàng từ', // applies_to_resource
    'custom_category' => 'Danh mục sản phẩm', // applies_to_resource
    'product' => 'Sản phẩm', // applies_to_resource
    CouponCampaign::APPLY_ONE_ORDER => '1 sản phẩm trên 1 đơn hàng', // applies_one
    CouponCampaign::APPLY_NOT_ONE_ORDER => 'Cho từng mặt hàng trong giỏ hàng', // applies_one
);
