<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceRatingMail;
use App\Models\EmailSettingAutomatic;
use App\Models\Invoice;
use App\Models\InvoiceRating;
use App\Models\KpiSetting;
use Illuminate\Support\Facades\Mail;

abstract class Controller
{

    /**
     * Gửi mail hoá đơn dưới 3 sao
     */
    public function mailInvoice($kiotviet_invoice_id)
    {
        try {
            $invoice = Invoice::where('kiotviet_id', $kiotviet_invoice_id)->first();
            $invoice_rating = InvoiceRating::where('kiotviet_invoice_id', $kiotviet_invoice_id)->with('customer')->first();

            if (empty($invoice) || empty($invoice_rating) || $invoice_rating->rating > 3) {
                return back()->with('error', 'Hoá đơn không được gửi mail');
            }

            // Danh sách email nhận (ví dụ lấy từ cấu hình hoặc database)
            $recipientEmails = EmailSettingAutomatic::where('type', 'email_invoice')->pluck('email')->toArray();

            if (empty($recipientEmails)) {
                return back()->with('error', 'Không có email nào để gửi.');
            }

            // Gửi email đến danh sách
            Mail::to($recipientEmails)->send(new InvoiceRatingMail($invoice, $invoice_rating));

            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * Thông tin cài đặt đánh giá
    */
    public function getKpiSetting(){
        $kpi_config = KpiSetting::first();

        return$kpi_config;
    }
}
