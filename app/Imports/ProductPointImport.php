<?php

namespace App\Imports;

use App\Models\ProductPoint;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductPointImport implements ToModel, WithHeadingRow
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

        $productPoint = ProductPoint::where('code', $productCode)->first();

        if ($productPoint) {
            // Nếu đã tồn tại thì cập nhật
            $productPoint->update([
                'name' => $row['ten_san_pham'] ?? $row['tên_sản_phẩm'],
                'point'        => $row['diem'] ?? $row['điểm'],
            ]);
            return null;
        } else {
            if (!empty($row['ten_san_pham']) && !empty($row['ma_san_pham']) && $row['diem']){
                return new ProductPoint([
                    'name'     => $row['ten_san_pham'] ?? $row['tên_sản_phẩm'],
                    'code'     => $productCode,
                    'point' => $row['diem'] ?? $row['điểm'],
                ]);
            }
        }
    }
}
