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
        return $this->belongsTo(Customer::class, 'kiotviet_id');
    }

    /**
     * Mối quan hệ: Một đánh giá thuộc về một hóa đơn.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'kiotviet_id');
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

        $invoiceRating = self::create($data);

        // Cập nhật điểm KPI cho nhân viên
        EmployeeKpi::updateKpiScore($invoiceRating->employee_id, $invoiceRating->rating);

        // Cập nhật tổng số chấm điểm sao cho nhân viên từ 1 -> 5 sao
        EmployeeRatingSummary::updateRatingSummary($invoiceRating->employee_id, $invoiceRating->rating);

        return $invoiceRating;
    }
}
