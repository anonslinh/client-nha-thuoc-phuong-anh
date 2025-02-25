<?php


namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\EmailSettingAutomatic;
use Illuminate\Http\Request;

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
}
