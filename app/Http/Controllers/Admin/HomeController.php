<?php


namespace App\Http\Controllers\Admin;


use App\Models\Gift;
use App\Models\RankModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
