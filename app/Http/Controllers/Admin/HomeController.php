<?php


namespace App\Http\Controllers\Admin;


use App\Models\CustomerRank;
use App\Models\Gift;
use App\Models\MembershipLevel;
use App\Models\RankModel;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController
{
    public function home (Request $request)
    {
        $listData = Gift::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('updated_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            if (!empty($value->rank_id)){
                $rank = MembershipLevel::find($value->rank_id);
                $value['name_rank'] = $rank->name??'Hạng thẻ đã bị khóa';
            }
        }
        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        return view('gift.list-data', compact('listData', 'rank'));
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
            return back()->with(['success' => 'Tạo voucher thành công']);
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
}
