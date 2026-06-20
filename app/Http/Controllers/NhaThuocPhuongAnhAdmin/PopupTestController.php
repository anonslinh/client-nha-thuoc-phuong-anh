<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;

class PopupTestController extends Controller
{
    const SETTING_CODE = 'popup_test_enabled';

    public function index()
    {
        $setting = GeneralSettings::where('code', self::SETTING_CODE)->first();

        if (empty($setting)) {
            $setting = new GeneralSettings([
                'code' => self::SETTING_CODE,
                'value' => 1,
            ]);
            $setting->save();
        }

        $enabled = $setting->value;

        return view('admin.catalog_v1.popup_test.index', compact('enabled'));
    }

    public function update(Request $request)
    {
        $setting = GeneralSettings::where('code', self::SETTING_CODE)->first();

        if (empty($setting)) {
            $setting = new GeneralSettings([
                'code' => self::SETTING_CODE,
                'value' => 1,
            ]);
        }

        $setting->value = $setting->value == 1 ? 0 : 1;
        $setting->save();

        return back()->with('success', $setting->value == 1 ? 'Đã bật popup thử nghiệm' : 'Đã tắt popup thử nghiệm');
    }
}
