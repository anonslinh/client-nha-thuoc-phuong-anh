<?php


namespace App\Http\Controllers\API;


use App\Models\CustomerOAFollow;
use App\Models\DailyActivitySummary;
use App\Models\SettingGlobal;
use Illuminate\Http\Request;

class SettingGlobalController extends HelperApiController
{
    /**
     * Kiểm tra xem khách hàng đã follow OA chưa
     */
    public function checkFollow(Request $request)
    {
        $oa_id = SettingGlobal::where('code', 'oa_id')->value('comment'); // Lấy giá trị nhanh hơn

        $is_followed = CustomerOAFollow::where('phone', $request->phone)
            ->where('oa_id', $oa_id)
            ->exists(); // Kiểm tra nhanh có tồn tại không

        return response()->json([
            'status' => $is_followed ? 0 : 1,
            'msg' => $is_followed ? "Đã follow OA!" : "Chưa follow OA!",
            'data' => $is_followed ? null : $oa_id
        ], 200);
    }
    /**
     * Follow OA
     */
    public function storeFollow(Request $request)
    {
        try{
            $request->validate([
                'phone' => 'required|string|max:20', // Bắt buộc có số điện thoại
            ]);

            $oa_id = SettingGlobal::where('code', 'oa_id')->value('comment');

            //Ghi log follow Zalo OA
            DailyActivitySummary::logAction($request->phone ? $request->phone :null, 'follow_oa');

            $followed = CustomerOAFollow::updateOrCreate(
                ['phone' => $request->phone, 'oa_id' => $oa_id],
                [] // Không cập nhật gì nếu đã tồn tại
            );

            return response()->json([
                'status' => $followed->wasRecentlyCreated ? 1 : 0,
                'msg' => $followed->wasRecentlyCreated ? "Follow OA thành công!" : "Đã follow OA!"
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'status' => 0,
                'msg' => $exception->errors(), // Trả về danh sách lỗi chi tiết
            ], 200);
        }
    }

}
