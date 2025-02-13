<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Customer;

class HelperApiController extends Controller
{
    /**
     * Chuẩn hóa số điện thoại: Chuyển '84xxxxxxxxx' thành '0xxxxxxxxx'
     */
    protected function normalizePhone($phone)
    {
        return preg_replace('/^84/', '0', $phone);
    }

    /**
     * Lấy thông tin khách hàng dựa trên số điện thoại.
     *
     * @param string $phone Số điện thoại khách hàng (có thể là 84xxxxxxxxx hoặc 0xxxxxxxxx)
     * @return Customer|null Trả về đối tượng Customer nếu tìm thấy, ngược lại trả về null
     */
    protected function getCustomerByPhone($phone)
    {
        // Chuẩn hóa số điện thoại: Nếu bắt đầu bằng '84', chuyển thành '0'
        $phone = preg_replace('/^84/', '0', $phone);

        // Tìm khách hàng có contact_number hợp lệ và khớp với số điện thoại
        return Customer::whereNotNull('contact_number') // Bỏ qua contact_number null
        ->where('contact_number', '!=', '') // Bỏ qua contact_number rỗng
        ->where('contact_number', $phone) // So khớp với số điện thoại đã chuẩn hóa
        ->first();
    }
}
