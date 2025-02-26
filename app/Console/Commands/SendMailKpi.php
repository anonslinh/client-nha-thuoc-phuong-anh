<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\EmployeeKpi;
use App\Models\SendMailKpiLog;
use App\Models\EmailSettingAutomatic;
use Illuminate\Support\Facades\Mail;
use function Carbon\this;

class SendMailKpi extends Command
{
    protected $signature = 'sendmail:kpi';
    protected $description = 'Gửi email cảnh báo KPI cho nhân viên';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        try{
            $this->info("Bắt đầu kiểm tra KPI nhân viên...");

            $today = Carbon::now();
            $employees = EmployeeKpi::where('month', $today->month)
                ->where('year', $today->year)
                ->where('points', '<', 70)
                ->with('employee')
                ->orderBy('points', 'asc') // Sắp xếp điểm từ thấp đến cao
                ->get();

            $employeesToNotify = [];

            foreach ($employees as $employee) {
                $lastMail = SendMailKpiLog::where('kiotviet_employee_id', $employee->kiotviet_employee_id)
                    ->orderBy('sent_at', 'desc')
                    ->first();

                $shouldSend = false;

                if ($employee->points < 40) {
                    if (!$lastMail || Carbon::parse($lastMail->sent_at)->diffInDays($today) >= 3) {
                        $shouldSend = true;
                    }
                } elseif ($employee->points < 60) {
                    if (!$lastMail || Carbon::parse($lastMail->sent_at)->diffInDays($today) >= 3) {
                        $shouldSend = true;
                    }
                } elseif ($employee->points < 70) {
                    if (!$lastMail || Carbon::parse($lastMail->sent_at)->diffInDays($today) >= 7) {
                        $shouldSend = true;
                    }
                }

                if ($shouldSend) {
                    $employeesToNotify[] = $employee;
                }
            }

            if (!empty($employeesToNotify)) {
                $this->sendKpiWarningEmail($employeesToNotify);
            } else {
                $this->info("Không có nhân viên nào cần gửi email.");
            }

            //Xoá dữ liệu nhân viên đã gửi trước đó 30 ngày.
            $this->deleteOldMailLogs();

            $this->info("Hoàn thành gửi email KPI.");
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Gửi mail danh sách nhân viên cảnh báo KPI
    */
    private function sendKpiWarningEmail($employeesToNotify)
    {
        try{
            $recipientEmails = EmailSettingAutomatic::where('type', 'email_employee')->pluck('email')->toArray();

            if (empty($recipientEmails)) {
                $this->info("Không có email nào để gửi.");
                return;
            }

            // Gửi mail
            Mail::send('send-emails.mail-employees-kpi', ['employeesToNotify' => $employeesToNotify], function ($message) use ($recipientEmails) {
                $message->to($recipientEmails)
                    ->subject("Cảnh báo KPI Nhân Viên");
            });

            foreach ($employeesToNotify as $employee) {
                // Lưu log gửi mail
                SendMailKpiLog::create([
                    'kiotviet_employee_id' => $employee->kiotviet_employee_id,
                    'sent_at' => Carbon::now(),
                ]);
            }

        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Xoá dữ liệu danh sách tài khoản gửi mail trước đó 30 ngày
    */
    private function deleteOldMailLogs()
    {
        try{
            $deleteBeforeDate = Carbon::now()->subDays(30);
            SendMailKpiLog::where('sent_at', '<', $deleteBeforeDate)->delete();

            $this->info("Đã xóa dữ liệu gửi mail trước ngày: " . $deleteBeforeDate->toDateString());
        }catch (\Exception $exception){
            dd($exception);
        }
    }

}
