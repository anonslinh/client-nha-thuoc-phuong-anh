<?php


namespace App\Http\Controllers\Admin;


use App\Models\AccountBranches;
use App\Models\Customer;
use App\Models\CustomerRank;
use App\Models\Gift;
use App\Models\GiftExchanges;
use App\Models\GiftInventories;
use App\Models\MembershipLevel;
use App\Models\RankModel;
use App\Models\TypeRankModel;
use App\Models\Voucher;
use App\Models\VoucherExchanges;
use App\Services\KiotVietService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class HomeController
{

    protected $kiotVietService;
    protected $urlKiotViet;

    public function __construct(KiotVietService $kiotVietService) {
        $this->kiotVietService = $kiotVietService;
        $this->urlKiotViet = $kiotVietService->urlKiotviet();
    }

    public function home ()
    {
        return view('dashboard');
    }

    public function logout ()
    {
        Auth::guard('users')->logout();
        return redirect()->route('login');
    }

    /**
     * Danh sách hạng thẻ
    **/
    public function listRank (Request $request)
    {
        $listData = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        foreach ($listData as $value){
            $value->total_customer = CustomerRank::where('current_rank', $value->rank)
                ->whereDate('rank_start_date', '<=', Carbon::now())->whereDate('rank_end_date', '>=', Carbon::now())->count();
        }
        $typeRank = TypeRankModel::first();
        return view('rank.list-data', compact('listData', 'typeRank'));
    }
    /**
     * Cấu hình hạng thẻ
    **/
    public function typeRank (Request $request)
    {
        $typeRank = TypeRankModel::first();
        $typeRank->type = $request->get('type');
        $typeRank->time = $request->get('time')??0;
        $typeRank->save();
        return back()->with(['success' => 'Cấu hình thành công']);
    }
    /**
     * Cập nhật hạng thẻ
    **/
    public function updateRank (Request $request, $id)
    {
        $rank = MembershipLevel::find($id);
        if (empty($rank)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/rank/', $nameFile);
            $rank->image = 'upload/rank/'.$nameFile;
        }
        $rank->name = $request->get('name');
        $rank->spending_threshold = $request->get('spending_threshold');
        $rank->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Danh sách voucher
    **/
    public function voucher (Request $request)
    {
        $listData = Voucher::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        if (isset($request->rank_id)){
            $listData = $listData->where('membership_levels_id', $request->get('rank_id'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            if (empty($value->membership_levels_id)){
                $value->rank_name = 'Không áp dụng';
            }else{
                $value->rank_name = MembershipLevel::find($value->membership_levels_id)->name??'Không tìm thấy';
            }
        }
        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        return view('voucher.list-data', compact('listData', 'rank'));
    }

    public function createdVoucher(){

        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        $account_branches = AccountBranches::where('active', 1)->get();

        return view('voucher.create', compact('rank', 'account_branches'));
    }

    public function detailVoucher($id){

        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        $account_branches = AccountBranches::where('active', 1)->get();
        $value = Voucher::find($id);
        if (empty($value)){
            return back()->with(['error' => 'Lỗi! không tìm thấy voucher']);
        }
        $release_code = json_decode($value->release_code, true);
        foreach ($account_branches as $account_branch){
            foreach ($release_code as $item){
                if ($account_branch->code == $item['code']){
                    $account_branch->release_code = $item['release_code'];
                }
            }
        }

        return view('voucher.detail', compact('rank', 'value', 'account_branches'));
    }

    /**
     * Tạo mới voucher
    **/
    public function storeVoucher (Request $request)
    {
        try{
            //Lấy id của voucher camping để khách hàng tạo voucher theo đợt phát hành và theo cửa hàng
            $release_code = $this->dataReleaseCode($request->branch);
            if (is_array($release_code) && empty($release_code)) {
                return back()->with(['error' => 'Mã phát hành không tồn tại!']);
            }

            $image = null;
            if ($request->hasFile('image')){
                $file = $request->file('image');
                $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/voucher/', $nameFile);
                $image = 'upload/voucher/'.$nameFile;
            }
            $voucher = new Voucher([
                'title' => $request->get('name'),
                'membership_levels_id' => $request->get('rank_id'),
                'image' => $image,
                'discount_amount' => $request->get('discount_amount'),
                'expiry_date' => $request->get('expiry_date'),
                'points_required' => $request->get('points_required'),
                'description' => $request->get('description'),
                'release_code' => json_encode($release_code)
            ]);
            $voucher->save();
            return redirect()->route('voucher.list-data')->with(['success' => 'Tạo voucher thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Lấy voucher campeign theo mã phát hành và tài khoản kiotviet
    */
    public function dataReleaseCode($array_release_code){
        try{
            $data_return = [];
            foreach ($array_release_code as $item){

                $tokens = $this->kiotVietService->getAccessTokenAllBranches($item['code']);
                $accessToken = $tokens->access_token;
                $retailer = $tokens->retailer;

                $pageSize = 100; // Số lượng tối đa mỗi lần gọi API
                $currentItem = 0; // Bắt đầu từ khách hàng đầu tiên

                $voucher_campaign_id = null;
                do{
                    $response = Http::withHeaders([
                        'Retailer'      => $retailer,
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type'  => 'application/json',
                    ])->get($this->urlKiotViet['url_voucher_campaign']."pageSize=$pageSize&currentItem=$currentItem");

                    if ($response->failed()) {
                        return back()->with(['error' => 'Không thể lấy dữ liệu từ KiotViet']);
                    }

                    // Kiểm tra xem có dữ liệu không
                    $responseData = $response->json()['data'] ?? [];
                    if (!isset($responseData) || empty($responseData)) {
                        break; // Dừng lại nếu không còn dữ liệu
                    }

                    foreach ($responseData as $responseItem) {
                        if ($item['release_code'] == $responseItem['code']){
                            $voucher_campaign_id = $responseItem['id'];
                            break;
                        }
                    }

                    // Cập nhật chỉ số để lấy trang tiếp theo
                    $currentItem += $pageSize;

                } while (count($responseData) === $pageSize); // Lặp cho đến khi hết dữ liệu

                $item['voucher_campaign_id'] = $voucher_campaign_id;
                if (!empty($voucher_campaign_id)){
                    array_push($data_return, $item);
                }
            }
            return $data_return;
        }catch (\Exception $exception){
            dd($exception);
        }
    }
    /**
     * Cập nhật voucher
    **/
    public function updateVoucher (Request $request, $id)
    {
        //Lấy id của voucher camping để khách hàng tạo voucher theo đợt phát hành và theo cửa hàng
        $release_code = $this->dataReleaseCode($request->branch);
        if (is_array($release_code) && empty($release_code)) {
            return back()->with(['error' => 'Mã phát hành không tồn tại!']);
        }

        $voucher = Voucher::find($id);
        if (empty($voucher)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/voucher/', $nameFile);
            $voucher->image = 'upload/voucher/'.$nameFile;
        }
        $voucher->title = $request->get('name');
        $voucher->membership_levels_id = $request->get('rank_id');
        $voucher->discount_amount = $request->get('discount_amount');
        $voucher->expiry_date = $request->get('expiry_date');
        $voucher->points_required = $request->get('points_required');
        $voucher->description = $request->get('description');
        $voucher->release_code = json_encode($release_code);
        $voucher->save();
        return back()->with(['success' => 'Cập nhật voucher thành công']);
    }
    /**
     * Xóa voucher
    **/
    public function deleteVoucher ($id)
    {
        $voucher = Voucher::find($id);
        if (empty($voucher)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        $voucher->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }

    /**
     * Danh sách khách hàng đổi voucher
    **/
    public function customerVoucher (Request $request)
    {
        $listData = VoucherExchanges::join('customers', 'customers.kiotviet_id', '=', 'voucher_exchanges.customer_id')
            ->join('vouchers', 'vouchers.id', '=', 'voucher_exchanges.voucher_id')
                ->select('voucher_exchanges.*', 'customers.name as name_customer', 'customers.contact_number as phone_customer',
                    'vouchers.title', 'vouchers.image');
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('customers.contact_number', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('customers.name', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('vouchers.title', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('voucher_exchanges.exchange_code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->status)){
            $listData = $listData->where('voucher_exchanges.status', $request->get('status'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        return view('voucher.customer', compact('listData'));
    }
    /**
     * Danh sách khách hàng đổi quà tặng
    **/
    public function customerExchangeGift (Request $request)
    {
        $listData = GiftExchanges::query();
        $listData = $listData->join('customers', 'customers.kiotviet_id', '=', 'gift_exchanges.customer_id')
            ->join('gifts', 'gifts.id', '=','gift_exchanges.gift_id')
            ->select('gift_exchanges.*','customers.name as name_customer', 'gifts.name', 'gifts.code', 'gifts.image');
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('customers.name', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('gift_exchanges.contact_phone', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('gifts.name', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('gifts.code', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('gift_exchanges.exchange_code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->status)){
            $listData = $listData->where('gift_exchanges.status', $request->get('status'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        return view('gift.customer', compact('listData'));
    }
    /**
     * Danh sách khách hàng
    **/
    public function customer(Request $request)
    {
        $listData = Customer::query()
            ->leftJoin('invoices', 'customers.kiotviet_id', '=', 'invoices.customer_id')
            ->select(
                'customers.id', 'customers.code', 'customers.name', 'customers.contact_number',
                'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points',
                \DB::raw('COUNT(invoices.id) as total_orders') // Tổng số đơn hàng trong ngày
            )
            ->groupBy('customers.id', 'customers.code', 'customers.name', 'customers.contact_number',
                'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points'); // Nhóm theo khách hàng

        // Tìm kiếm theo key_search (kiotviet_id, code, contact_number, address)
        if (isset($request->key_search)) {
            $search = $request->get('key_search');
            $listData->where(function ($query) use ($search) {
                $query->where('customers.kiotviet_id', 'like', "%$search%")
                    ->orWhere('customers.code', 'like', "%$search%")
                    ->orWhere('customers.contact_number', 'like', "%$search%")
                    ->orWhere('customers.address', 'like', "%$search%");
            });
        }

        // Sắp xếp theo tổng tiền hóa đơn hoặc tổng điểm
        if (isset($request->sort)) {
            if ($request->get('sort') == 'total_invoiced') {
                $listData->orderBy('customers.total_invoiced', 'desc');
            } elseif ($request->get('sort') == 'total_point') {
                $listData->orderBy('customers.total_point', 'desc');
            }
        } else {
            $listData->orderBy('customers.created_at', 'desc');
        }

        // Phân trang 20 bản ghi
        $listData = $listData->paginate(20);

        return view('customer.index', compact('listData'));
    }

    /**
     * Hoàn điểm cho khách hàng
    **/
    public function customerExchangeGiftReturn ($id)
    {
        $giftExchange = GiftExchanges::find($id);
        if (empty($giftExchange)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        if ($giftExchange->status != 'pending'){
            return back()->with(['error' => 'Không thể hoàn điểm cho khách hàng khi trạng thái không phải là chưa sử dụng']);
        }
        $quantity = GiftInventories::where('gift_id', $id)->where('branch_id', $giftExchange->branch_id)->first();
        if (isset($quantity)){
            $quantity->quantity += 1;
            $quantity->save();
        }
        $giftExchange->status = 'cancelled';
        $giftExchange->save();
        $customer = Customer::where('kiotviet_id', $giftExchange->customer_id)->first();
        $customer->reward_point += $giftExchange->points_used;
        $customer->save();
        return back()->with(['success' => 'Hoàn điểm cho khách hàng thành công']);
    }
}
