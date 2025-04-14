<?php

namespace App\Imports;

use App\Models\ProductCertificate;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductCertificateImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $productCode = $row['ma_san_pham'] ?? $row['mã_sản_phẩm']; // hỗ trợ tên cột có dấu hoặc không

        if (!$productCode) return null;

        $certificate = ProductCertificate::where('product_code', $productCode)->first();

        if ($certificate) {
            // Nếu đã tồn tại thì cập nhật
            $certificate->update([
                'product_name'     => $row['ten_san_pham'] ?? $row['tên_sản_phẩm'],
                'certificate_link' => $row['link_giay_chung_nhan'] ?? $row['link_giấy_chứng_nhận'],
                'is_active'        => true,
            ]);
            return null; // không tạo mới
        } else {
            // Tạo mới nếu chưa tồn tại
            return new ProductCertificate([
                'product_name'     => $row['ten_san_pham'] ?? $row['tên_sản_phẩm'],
                'product_code'     => $productCode,
                'certificate_link' => $row['link_giay_chung_nhan'] ?? $row['link_giấy_chứng_nhận'],
                'is_active'        => true,
            ]);
        }
    }
}
