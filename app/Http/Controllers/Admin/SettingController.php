<?php


namespace App\Http\Controllers\Admin;


use App\Exports\ProductPointExport;
use App\Imports\ProductPointImport;
use App\Models\AccountBranches;
use App\Models\Branch;
use App\Models\Contacts;
use App\Models\Employee;
use App\Models\GeneralSettings;
use App\Models\HistoryPointCustomer;
use App\Models\KpiSetting;
use App\Models\ProductPoint;
use App\Models\SettingGlobal;
use App\Models\Slogan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Services\KiotVietService;

use App\Models\PersonalAccessTokens;
use Maatwebsite\Excel\Facades\Excel;

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
        $type_point = GeneralSettings::where('code', 'type_point')->first()->value??1;
        return view('config.setting-global', compact('listData', 'type_point'));
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

    /**
     * Thay đổi hình thức tích điểm
    **/
    public function changeTypePoint (Request $request)
    {
        $setting = GeneralSettings::where('code', 'type_point')->first();
        $setting->value = $request->get('value')??1;
        $setting->save();
        return response()->json(['status' => true, 'msg' => 'Thay đổi hình thức tích điểm thành công'], 200);
    }

    /**
     * Danh sách sản phẩm
    **/
    public function listProduct (Request $request)
    {
        $listProduct = ProductPoint::query();
        if (isset($request->key_search)){
            $listProduct = $listProduct->where(function ($query) use ($request){
                $query->where('code', 'like', '%'.$request->get('key_search').'%')->orWhere('name', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->category_id)){
            $listProduct = $listProduct->where('category_id', $request->get('category_id'));
        }
        $listProduct = $listProduct->orderBy('created_at', 'desc')->paginate(40);
        $category = $this->listCategories();
        return view('config.list-product', compact('listProduct', 'category'));
    }

    public function excelProduct ()
    {
        $month = now()->month;
        $year = now()->year;
        return Excel::download(new ProductPointExport(), "list-product-$month-$year.xlsx");
    }

    public function importProduct (Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new ProductPointImport(), $request->file('file'));

        return back()->with('success', 'Import thành công!');
    }

    public function deleteProduct($id)
    {
        $product = ProductPoint::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Dữ liệu không tồn tịa']);
        }
        $product->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }

    public function addProduct (Request $request)
    {
        $category = $request->get('category');
        $category = explode(',', $category);
        $categoryID = $category[0];
        $retailer = $category[1];
        $listProduct = [];
        $account = AccountBranches::where('retailer', $retailer)->first();
        $token = $this->kiotVietService->refreshTokenAllBranches($account->client_id,$account->client_secret,$account->code,$retailer);
        $dataToken = $token->access_token;
        $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
        $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên
        do{
            $response = Http::withHeaders([
                'Retailer'      => $retailer,
                'Authorization' => 'Bearer ' . $dataToken,
                'Content-Type'  => 'application/json',
            ])->get($this->urlKiotViet['url_list_product']."pageSize=$pageSize&currentItem=$currentItem&categoryId=$categoryID");

            if ($response->failed()) {
                break;
            }
            $responseData = $response->json()['data'] ?? [];
            if (!isset($responseData) || empty($responseData)) {
                break; // Dừng lại nếu không còn dữ liệu
            }
            foreach ($responseData as $item){
                $productItem = [
                    'code' => $item['code'],
                    'name' => $item['name'],
                    'category_id' => $item['categoryId'],
                    'point' => $request->get('point'),
                    'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                    'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                ];
                $listProduct[] = $productItem;
            }
            $currentItem += $pageSize;
        }while (count($responseData) === $pageSize);
        DB::table('product_point')->upsert(
            $listProduct,
            ['code'],
            ['name', 'category_id', 'point']
        );
        return back()->with(['success' => 'Cấu cài đặt sản phẩm thành công']);
    }

    public function historyPoint (Request $request)
    {
        $listData = HistoryPointCustomer::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('phone_customer', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('name_customer', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('order_code', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('title', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(40);
        return view('config.history_point', compact('listData'));
    }
}
