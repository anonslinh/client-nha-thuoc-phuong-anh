<?php


namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Gift;
use App\Models\Program;

class HomeController extends HelperApiController
{
    /**
     * Tổng điểm hiện tại của khách hàng
     */
    public function rewardPointCustomer(Request $request)
    {
        try {
            // Validate số điện thoại
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $phone = $this->normalizePhone($validatedData['phone']);

            // Lấy thông tin khách hàng & điểm thưởng
            $reward_point = optional(Customer::where('contact_number', $phone)->first())->reward_point ?? 0;

            return response()->json([
                'status' => true,
                'data' => $reward_point
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Banner mini app theo chi nhánh hoặc toàn bộ hệ thống!
    */
    public function getBanners(Request $request)
    {
        $customer = $this->getCustomerByPhone($request->phone);
        $branchId = $customer->branch_id ?? null;

        $banners = Banner::where(function ($query) use ($branchId) {
            $query->whereNull('branch_id') // Banner toàn hệ thống
            ->orWhere('branch_id', $branchId); // Banner cho chi nhánh cụ thể
        })
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhereRaw('start_date <= NOW()'); // Sử dụng raw để tránh lỗi time zone
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhereRaw('end_date >= NOW()');
            })
            ->get();

        return response()->json(['status' => true, 'data' => $banners]);
    }

    /**
     * Danh sách quà tặng
    */
    public function getGifts(Request $request)
    {
        $customer = $this->getCustomerByPhone($request->phone);
        $branchId = $customer->branch_id ?? null;
        $rewardPoint = $customer->reward_point ?? 0; // Điểm thưởng của khách hàng (mặc định là 0 nếu không có)

        // Lấy số lượng item mỗi trang (mặc định 10)
        $perPage = $request->input('per_page', 10);

        // Truy vấn danh sách quà tặng
        $gifts = Gift::where(function ($query) use ($branchId) {
            if ($branchId) {
                // Nếu có branch_id, lấy quà của chi nhánh đó
                $query->where('branch_id', $branchId);
            } else {
                // Nếu chưa có branch_id, chỉ lấy quà trưng bày
                $query->where('is_display', true);
            }
        })->paginate($perPage);

        return response()->json([
            'status' => true,
            'reward_point' => $rewardPoint,
            'data' => $gifts
        ]);
    }

    /**
     * Danh sách chương trình khuyến mại
    */
    public function getPrograms(Request $request)
    {
        $customer = $this->getCustomerByPhone($request->phone);
        $branchId = $customer->branch_id ?? null;

        $perPage = $request->input('per_page', 10);

        $programs = Program::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($query) use ($branchId) {
                if ($branchId) {
                    $query->where('branch_id', $branchId);
                }
            })
            ->orderByDesc('priority')
            ->orderBy('start_date', 'asc')
            ->paginate($perPage);

        $programs->getCollection()->transform(function ($program) {
            return [
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'branch_id' => $program->branch_id,
                'branch_name' => optional($program->branch)->branch_name ?? 'Toàn hệ thống',
                'thumbnail' => $program->thumbnail,
                'images' => $program->images,
                'start_time' => $program->start_time,
                'end_time' => $program->end_time,
                'can_join' => !empty($program->join_link) && $program->active_join_link,
                'join_link' => $program->active_join_link ? $program->join_link : null
            ];
        });

        return response()->json(['status' => true, 'data' => $programs]);
    }

}
