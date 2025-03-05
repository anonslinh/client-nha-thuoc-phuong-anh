<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceRating extends Model
{
    use HasFactory;

    protected $table = 'invoice_ratings';

    protected $fillable = [
        'kiotviet_invoice_id',
        'kiotviet_customer_id',
        'employee_id',
        'rating',
        'comment'
    ];

    /**
     * Mối quan hệ: Một đánh giá thuộc về một nhân viên.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Mối quan hệ: Một đánh giá thuộc về một khách hàng.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'kiotviet_customer_id','kiotviet_id');
    }

    /**
     * Mối quan hệ: Một đánh giá thuộc về một hóa đơn.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'kiotviet_invoice_id', 'kiotviet_id');
    }

    /**
     * Lưu đánh giá hóa đơn và cập nhật điểm KPI nhân viên.
     */
    public static function createRating($data)
    {

        // Kiểm tra xem hóa đơn đã được đánh giá chưa
        if (self::where('kiotviet_invoice_id', $data['kiotviet_invoice_id'])->exists()) {
            throw new \Exception('Hóa đơn này đã được đánh giá trước đó');
        }

        \DB::beginTransaction();

        try {
            $invoice = Invoice::where('kiotviet_id', $data['kiotviet_invoice_id'])->first();
            if (empty($invoice)){
                throw new \Exception('Hóa đơn không tồn tại');
            }
            $invoiceRating = self::create($data);

            // Cập nhật tổng số chấm điểm sao cho nhân viên từ 1 -> 5 sao
            EmployeeRatingSummary::updateRatingSummary($invoiceRating->employee_id, $invoiceRating->rating);

            // Lấy cấu hình KPI từ bảng kpi_settings
            $kpiConfig = KpiSetting::first();
            if (!$kpiConfig) {
                throw new \Exception("Lỗi: Cấu hình KPI chưa được thiết lập!");
            }else{
                // Cập nhật điểm KPI cho nhân viên
                EmployeeKpi::updateKpiScore($invoiceRating->employee_id, $invoiceRating->rating, $kpiConfig);

                // Lấy thông tin khách hàng
                $customer = Customer::where('kiotviet_id', $data['kiotviet_customer_id'])->first();

                if ($customer && ($invoice->total_payment >= $kpiConfig->min_order_value)) {
                    // Tăng review_count lên 1
                    $customer->increment('review_count');

                    // Nếu review_count là bội số của 10, trừ used_points đi 1
                    if ($customer->review_count % $kpiConfig->orders_required === 0) {
                        $customer->decrement('used_points', $kpiConfig->reward_points);
                    }
                }
            }

            \DB::commit();

            return $invoiceRating;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
