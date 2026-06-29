<?php

namespace App\Http\Controllers\NhaThuocPhuongAnhAdmin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;

class PopupTestController extends Controller
{
    const CODE_ENABLED = 'popup_test_enabled';
    const CODE_TITLE = 'popup_test_title';
    const CODE_DESCRIPTION = 'popup_test_description';
    const CODE_ALWAYS_SHOW = 'popup_test_always_show';

    const DEFAULT_TITLE = 'Website đang trong giai đoạn thử nghiệm';
    const DEFAULT_DESCRIPTION = 'Nhà thuốc Phương Anh đang trong quá trình hoàn thiện website. Một số chức năng có thể chưa hoạt động hoàn hảo. Rất mong nhận được góp ý của bạn để chúng tôi cải thiện trải nghiệm tốt hơn!';

    public function index()
    {
        $enabled = (int) $this->getSetting(self::CODE_ENABLED, 1);
        $alwaysShow = (int) $this->getSetting(self::CODE_ALWAYS_SHOW, 1);
        $title = $this->getSetting(self::CODE_TITLE, self::DEFAULT_TITLE);
        $description = $this->getSetting(self::CODE_DESCRIPTION, self::DEFAULT_DESCRIPTION);

        return view('admin.catalog_v1.popup_test.index', compact('enabled', 'alwaysShow', 'title', 'description'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000'],
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề popup.',
            'description.required' => 'Vui lòng nhập nội dung mô tả.',
        ]);

        $this->setSetting(self::CODE_TITLE, trim($validated['title']));
        $this->setSetting(self::CODE_DESCRIPTION, trim($validated['description']));
        $this->setSetting(self::CODE_ENABLED, $request->boolean('enabled') ? 1 : 0);
        $this->setSetting(self::CODE_ALWAYS_SHOW, $request->boolean('always_show') ? 1 : 0);

        return back()->with('success', 'Cập nhật popup thử nghiệm thành công.');
    }

    protected function getSetting(string $code, $default = null)
    {
        $value = GeneralSettings::where('code', $code)->value('value');

        return $value === null ? $default : $value;
    }

    protected function setSetting(string $code, $value): void
    {
        GeneralSettings::updateOrCreate(
            ['code' => $code],
            ['value' => $value]
        );
    }
}
