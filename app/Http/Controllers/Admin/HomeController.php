<?php


namespace App\Http\Controllers\Admin;


use App\Models\Customer;
use App\Models\CustomerRank;
use App\Models\Gift;
use App\Models\GiftExchanges;
use App\Models\MembershipLevel;
use App\Models\RankModel;
use App\Models\Voucher;
use App\Models\VoucherExchanges;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController
{
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
        return view('rank.list-data', compact('listData'));
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

        return view('voucher.create', compact('rank'));
    }

    public function detailVoucher($id){

        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        $value = Voucher::find($id);
        if (empty($value)){
            return back()->with(['error' => 'Lỗi! không tìm thấy voucher']);
        }

        return view('voucher.detail', compact('rank', 'value'));
    }

    /**
     * Tạo mới voucher
    **/
    public function storeVoucher (Request $request)
    {
        try{
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
                'description' => $request->get('description')
            ]);
            $voucher->save();
            return redirect()->route('voucher.list-data')->with(['success' => 'Tạo voucher thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Cập nhật voucher
    **/
    public function updateVoucher (Request $request, $id)
    {
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
}
