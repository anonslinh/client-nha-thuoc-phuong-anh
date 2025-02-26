<?php


namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\EmailSettingAutomatic;
use App\Models\Employee;
use App\Models\EmployeeKpi;
use App\Models\Invoice;
use App\Models\InvoiceRating;
use App\Models\SendMailKpiLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\InvoiceRatingMail;
use Illuminate\Support\Facades\Mail;

class SettingAIAgentsController extends HelperAdminController
{
    public function indexEmailSettingAutomatic()
    {
        $listData = EmailSettingAutomatic::with('branch')->orderBy('id', 'desc')->paginate(20);

        $branches = Branch::all();

        return view('setting-automatic.index-email-setting', compact('listData', 'branches'));
    }

    public function storeEmailSettingAutomatic(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'email' => 'required|email'
        ]);

        EmailSettingAutomatic::create($request->all());
        return back()->with('success', 'Email setting created successfully.');
    }

    public function updateEmailSettingAutomatic(Request $request, $id)
    {
        $emailSetting = EmailSettingAutomatic::findOrFail($id);
        $request->validate([
            'branch_id' => 'exists:branches,kiotviet_id',
            'type' => 'string',
            'email' => 'email'
        ]);

        $emailSetting->update($request->all());
        return back()->with('success', 'Email setting updated successfully.');
    }

    public function destroyEmailSettingAutomatic($id)
    {
        EmailSettingAutomatic::destroy($id);
        return back()->with('success', 'Email setting deleted successfully.');
    }

    /**
     * Test mail
    */
    public function testMailInvoice($kiotviet_invoice_id){
        $data = $this->mailInvoice($kiotviet_invoice_id);
        if ($data){
            return back()->with('success', 'Send Email successfully.');
        }else{
            return back()->with('error', 'Send Email error.');
        }
    }

    /**
     * Test gửi danh sách nhân viên KPI điểm thấp
    */
    public function sendMailKpiEmployee(){
        try{

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

//            $recipientEmails = EmailSettingAutomatic::where('type', 'email_employee')->pluck('email')->toArray();
//
//            if (empty($recipientEmails)) {
//                dd("Không có email nào để gửi.");
//            }
//
//            // Gửi mail
//            Mail::send('send-emails.mail-employees-kpi', ['employeesToNotify' => $employeesToNotify], function ($message) use ($recipientEmails) {
//                $message->to($recipientEmails)
//                    ->subject("Cảnh báo KPI Nhân Viên");
//            });
//            dd('123');
            return view('send-emails.mail-employees-kpi', compact('employeesToNotify'));

        }catch (\Exception $exception){
            dd($exception);
        }
    }
}
