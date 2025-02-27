<?php

namespace App\Console\Commands;


use App\Models\EmailSettingAutomatic;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeeExport;
use App\Mail\EmployeeReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SendEmployeeReportCommand extends Command
{
    protected $signature = 'report-employee-month:kpi';
    protected $description = 'Xuất file Excel và gửi báo cáo nhân viên qua email vào 23h ngày cuối cùng của tháng';

    public function handle()
    {
        $month = now()->month;
        $year = now()->year;
        $fileName = "employee_report_{$month}_{$year}.xlsx";
        $filePath = "reports/$fileName";

        $recipientEmails = EmailSettingAutomatic::where('type', 'email_employee')->pluck('email')->toArray();

        if (empty($recipientEmails)) {
            $this->info("Không có email nào để gửi.");
            return;
        }
        //Xuất file Excel
        Excel::store(new EmployeeExport(), $filePath, 'local');

        if (!Storage::exists($filePath)) {
            $this->error("Lỗi: Không thể tạo file báo cáo.");
            return;
        }

        //Gửi email kèm file
        foreach ($recipientEmails as $email) {
            Mail::to($email)->send(new EmployeeReportMail($filePath));
            $this->info("✅ Đã gửi báo cáo đến: $email");
        }

        //Xóa file sau khi gửi
        Storage::delete($filePath);
    }
}
