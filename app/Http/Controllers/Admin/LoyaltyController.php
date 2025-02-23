<?php


namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\MiniGame;
use Illuminate\Http\Request;

class LoyaltyController extends HelperAdminController
{
    /**
     * Danh sách mini game
    */
    public function getMiniGames(){
        $listData = MiniGame::orderBy('created_at', 'desc')->paginate(20);

        $branches = Branch::all();

        return view('loyalty.mini-game', compact('listData', 'branches'));
    }

    /**
     * Cập nhật thông tin Mini Game
     */
    public function updateMiniGame(Request $request, $id)
    {
        $data = MiniGame::find($id);
        if (empty($data)) {
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }

        $data->title = $request->get('title');
        $data->link = $request->get('link');
        $data->branch_id = $request->get('branch_id');
        $data->start_time = $request->get('start_time');
        $data->end_time = $request->get('end_time');
        $data->status = $request->get('status');

        $data->save();

        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }

    /**
     * Xóa Mini Game
     */
    public function deleteMiniGame($id)
    {
        $data = MiniGame::find($id);
        if (empty($data)) {
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }

        $data->delete();

        return back()->with(['success' => 'Xóa mini game thành công']);
    }

    /**
     * Thêm mới Mini Game
     */
    public function storeMiniGame(Request $request)
    {
        try{
            $request->validate([
                'title' => 'required|string|max:255',
                'link' => 'nullable|url',
                'branch_id' => 'nullable|exists:branches,kiotviet_id',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'status' => 'required|in:active,inactive',
            ]);

            $miniGame = new MiniGame();
            $miniGame->title = $request->get('title');
            $miniGame->link = $request->get('link');
            $miniGame->branch_id = $request->get('branch_id');
            $miniGame->start_time = $request->get('start_time');
            $miniGame->end_time = $request->get('end_time');
            $miniGame->status = $request->get('status');

            $miniGame->save();

            return back()->with(['success' => 'Thêm mới mini game thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }

}
