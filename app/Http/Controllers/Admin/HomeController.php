<?php


namespace App\Http\Controllers\Admin;


use App\Models\CustomerRank;
use App\Models\Gift;
use App\Models\MembershipLevel;
use App\Models\RankModel;
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
                $rank = RankModel::find($value->rank_id);
                $value['name_rank'] = $rank->name??'Hạng thẻ đã bị khóa';
            }
        }
        return view('gift.list-data', compact('listData'));
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
}
