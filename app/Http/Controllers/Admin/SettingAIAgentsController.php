<?php


namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\EmailSettingAutomatic;
use App\Models\Invoice;
use App\Models\InvoiceRating;
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
}
