<?php


namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Gift;
use App\Models\Program;
use App\Models\CustomerRank;
use App\Models\CustomerSpendingSummary;
use App\Models\MembershipLevel;
use App\Models\Voucher;

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

            $this->syncCustomerInvoices($phone);
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
     * Danh sách chương trình
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

    /**
     * Danh sách khuyến mại
    */
    public function getPromotions(Request $request){
        $perPage = $request->input('per_page', 10);

        $promotion = Promotion::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->orderByDesc('priority')
            ->orderBy('start_date', 'asc')
            ->paginate($perPage);

        return response()->json(['status' => true, 'data' => $promotion]);
    }

    /**
     * Hạng thẻ của khách hàng
    */
    public function getMembershipInfo(Request $request){
        try {
            // Validate số điện thoại
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $phone = $this->normalizePhone($validatedData['phone']);

            $this->syncCustomerInvoices($phone);

            // Tìm khách hàng theo số điện thoại
            $customer = Customer::where('contact_number', $phone)->first();

            if (!$customer) {
                return response()->json(['message' => 'Khách hàng không tồn tại'], 404);
            }

            // Lấy tổng chi tiêu của khách hàng
            $totalSpent = CustomerSpendingSummary::where('customer_id', $customer->kiotviet_id)->sum('total_spent');

            // Lấy hạng thẻ hiện tại
            $currentRank = CustomerRank::where('customer_id', $customer->kiotviet_id)->first();

            // Nếu chưa có hạng, mặc định "Thân Thiết"
            if (!$currentRank) {
                $currentRank = MembershipLevel::where('rank', 'than_thiet')->first();
            } else {
                $currentRank = MembershipLevel::where('rank', $currentRank->current_rank)->first();
            }

            // Tìm hạng tiếp theo cần thăng
            $nextRank = MembershipLevel::where('spending_threshold', '>', $totalSpent)
                ->orderBy('spending_threshold', 'asc')
                ->first();

            // Nếu không còn hạng cao hơn
            $amountNeeded = $nextRank ? max(0, $nextRank->spending_threshold - $totalSpent) : 0;

            $data_return = [
                'customer_name'   => $customer->name,
                'phone'           => $customer->contact_number,
                'current_rank'    => $currentRank->name ?? 'Thân Thiết',
                'current_rank_code'    => $currentRank->rank ?? 'than_thiet',
                'image' => $currentRank->image,
                'total_spent'     => $totalSpent,
                'next_rank'       => $nextRank->name ?? null,
                'amount_to_next'  => $amountNeeded,
            ];

            return response()->json([
                'status' => true,
                'data' => $data_return
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Danh sách voucher
    */
    public function getVouchers(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $vouchers = Voucher::where('expiry_date', '>=', now())
            ->orderBy('expiry_date', 'asc')
            ->paginate($perPage);

        return response()->json([
            'status' => true,
            'data' => $vouchers
        ]);
    }

}
