<?php


namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\Contacts;
use App\Models\Employee;
use App\Models\KpiSetting;
use App\Models\SettingGlobal;
use App\Models\Slogan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends SyncController
{
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

        $listData = Branch::orderBy('created_at', 'desc')->paginate(20);
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
}
