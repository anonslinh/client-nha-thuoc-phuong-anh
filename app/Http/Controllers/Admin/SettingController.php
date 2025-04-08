<?php


namespace App\Http\Controllers\Admin;


use App\Models\AccountBranches;
use App\Models\Branch;
use App\Models\Contacts;
use App\Models\Employee;
use App\Models\KpiSetting;
use App\Models\SettingGlobal;
use App\Models\Slogan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\KiotVietService;

use App\Models\PersonalAccessTokens;

class SettingController extends SyncController
{

    protected $kiotVietService;
    protected $urlKiotViet;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
        $this->urlKiotViet = $kiotVietService->urlKiotviet();
    }

    /**
     * danh sách nhân viên
    */
    public function getEmployees(){

        $listData = Employee::orderBy('created_at', 'desc')->paginate(20);
        $totalEmployees = $listData->total(); // Lấy tổng số nhân viên

        return view('config.employees-sync', compact('listData', 'totalEmployees'));
    }

    /**
     * danh sách chi nhánh
    */
    public function getBranches(){

        $listData = Branch::orderBy('created_at', 'desc')->where('is_active', 1)->paginate(20);
        $totalBranches = $listData->total();
        return view('config.branches-sync', compact('listData', 'totalBranches'));
    }

    /**
     * Liên hệ & phản hồi
    */
    public function getContacts(){
        $listData = Contacts::all();
        return view('config.contacts', compact('listData'));
    }

    /**
     * Cập nhật phản hồi & liên hệ
    */
    public function updateContact (Request $request, $id)
    {
        $data = Contacts::find($id);
        if (empty($data)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/config/', $nameFile);
            $data->icon = 'upload/config/'.$nameFile;
        }
        $data->name = $request->get('name');
        $data->value = $request->get('value');
        $data->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }

    /**
     * Slogan
    */
    public function getSlogan(){
        $listData = Slogan::all();
        return view('config.slogan', compact('listData'));
    }

    /**
     * Cập nhật Slogan
     */
    public function updateSlogan (Request $request, $id)
    {
        $data = Slogan::find($id);
        if (empty($data)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        $data->title = $request->get('title');
        $data->save();

        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }

    /**
     * Cài đặt điểm đánh giá đơn hàng
    */
    public function settingPointOrderReview(){
        $data = KpiSetting::find(1);
        if (empty($data)){
            return back()->with(['error' => 'Lỗi liên hệ với bộ phận CSKH']);
        }

        return view('config.setting-point-order-review', compact('data'));
    }

    /**
     * Cập nhật điểm đánh giá đơn hàng
     */
    public function updateSettingPointOrderReview(Request $request)
    {
        $data = KpiSetting::find(1);

        if (!$data) {
            return back()->with(['error' => 'Lỗi liên hệ với bộ phận CSKH']);
        }

        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'cutoff_date' => 'required|date|before_or_equal:today', // Ngày không được vượt quá hôm nay
            'star_1' => 'required|integer',
            'star_2' => 'required|integer',
            'star_3' => 'required|integer',
            'star_4' => 'required|integer',
            'star_5' => 'required|integer',
            'orders_required' => 'required|integer|min:1',
            'min_order_value' => 'required|integer|min:0',
            'reward_points' => 'required|integer|min:0',
        ]);

        // Cập nhật dữ liệu
        $data->update($validated);

        return back()->with(['success' => 'Cập nhật thành công!']);
    }


    /**
     * Cài đặt chung
     * OA ID của cửa hàng
     */
    public function settingGlobal(){
        $listData = SettingGlobal::all();
        if (empty($listData)){
            return back()->with(['error' => 'Lỗi liên hệ với bộ phận CSKH']);
        }

        return view('config.setting-global', compact('listData'));
    }

    /**
     * Cập nhật cài đặt chung
     */
    public function updateSettingGlobal (Request $request, $id)
    {
        $data = SettingGlobal::find($id);
        if (empty($data)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'comment' => 'required',
        ]);

        // Cập nhật dữ liệu
        $data->update($validated);
        $data->comment = $request->get('comment');
        $data->save();

        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }

    /**
     * Danh sách tài khoản kiotviet
    */
    public function indexAccountBranches(){
        $listData = AccountBranches::where('active', 1)->orderBy('created_at', 'desc')->paginate(20);

        return view('config.account-branches', compact('listData'));
    }

    /**
     * Thêm tài khoản kiotviet
    */
    public function storeAccountBranch(Request $request)
    {
        // Kiểm tra số lượng account branch không cho vượt quá giới hạn
        $count = AccountBranches::count();
        if ($count >= 1) {
            return back()->with(['error' => 'Chỉ được tạo tối đa 1 tài khoản. Liên hệ để mở thêm!']);
        }

        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:255|unique:account_branches,code',
            'retailer'      => 'required|string|max:255',
            'client_id'     => 'required|string|max:255|unique:account_branches,client_id',
            'client_secret' => 'required|string|max:255|unique:account_branches,client_secret',
        ]);

        try {
            // Gọi API lấy token mới
            $token = $this->kiotVietService->refreshTokenAllBranches(
                $validatedData['client_id'],
                $validatedData['client_secret'],
                $validatedData['code'],
                $validatedData['retailer']
            );

            if (!$token) {
                return back()->with(['error' => 'Lỗi khi lấy token từ KiotViet']);
            }

            // Tạo mới dữ liệu
            AccountBranches::create($validatedData);

            return back()->with(['success' => 'Thêm dữ liệu thành công!']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    /**
     * cập nhật thông tin tài khoản
    */
    public function updateAccountBranch(Request $request, $id)
    {
        return back()->with(['error' => 'Không được chỉnh sửa tài khoản khi đang hoạt động! Liên hệ để mở tính năng sửa']);
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => "required|string|max:255|unique:account_branches,code,$id",
            'retailer'      => "required|string|max:255",
            'client_id'     => "required|string|max:255|unique:account_branches,client_id,$id",
            'client_secret' => "required|string|max:255|unique:account_branches,client_secret,$id",
        ]);

        // Lấy bản ghi cần cập nhật
        $accountBranch = AccountBranches::findOrFail($id);

        try {
            // Gọi API lấy token mới
            $token = $this->kiotVietService->refreshTokenAllBranches(
                $validatedData['client_id'],
                $validatedData['client_secret'],
                $validatedData['code'],
                $validatedData['retailer']
            );

            if (!$token) {
                return back()->with(['error' => 'Lỗi khi lấy token từ KiotViet']);
            }

            // Cập nhật dữ liệu nếu lấy token thành công
            $accountBranch->update($validatedData);

            return back()->with(['success' => 'Cập nhật thành công!']);
        } catch (\Exception $e) {
            return back()->with(['error' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    /**
     * xóa tài khoản
    */
    public function deleteAccountBranch($id)
    {
        $accountBranch = AccountBranches::findOrFail($id);
        $personalAccessTokens = PersonalAccessTokens::where('access_token_code', $accountBranch->code)->firstOrFail();
        $personalAccessTokens->delete();
        $accountBranch->delete();

        return back()->with(['success' => 'Xóa thành công!']);
    }
}
