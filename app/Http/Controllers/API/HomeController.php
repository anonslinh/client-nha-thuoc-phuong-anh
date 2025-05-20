<?php


namespace App\Http\Controllers\API;

use App\Models\BannerBranch;
use App\Models\Branch;
use App\Models\Contacts;
use App\Models\Customer;
use App\Models\DailyActivitySummary;
use App\Models\ProgramBranch;
use App\Models\Promotion;
use App\Models\Slogan;
use App\Models\TypeRankModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Gift;
use App\Models\Program;
use App\Models\CustomerRank;
use App\Models\CustomerSpendingSummary;
use App\Models\MembershipLevel;
use App\Models\Voucher;
use App\Models\MiniGame;
use App\Models\TermsExchangeGift;

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
            $membership_level = $this->getMembershipLevel($phone);
            $customer = Customer::where('contact_number', $phone)->first();
            // Lấy thông tin khách hàng & điểm thưởng
            $reward_point = optional($customer)->reward_point ?? 0;

            //Ghi log đếm số lượng truy cập xem điểm
            DailyActivitySummary::logAction(optional($customer)->kiotviet_id ?? null, 'view_points');

            return response()->json([
                'status' => true,
                'data' => $reward_point,
                'membership_level' => $membership_level
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
        $customer = $this->getCustomerByPhone($request->get('phone'));
        if (isset($customer->branch_id)){
            $branch = Branch::where('kiotviet_id', $customer->branch_id)->first();
            if (isset($branch)){
                $branchId = BannerBranch::where('branch_id', $branch->id)->pluck('banner_id')->toArray();
            }else{
                $branchId = [];
            }
        }else{
            $branchId = [];
        }
        $bannerID = BannerBranch::pluck('banner_id')->toArray();
        //Ghi log đếm số lượng truy cập ứng dụng
        DailyActivitySummary::logAction($customer->kiotviet_id ?? null, 'access_to');
        $banners = Banner::where(function ($query) use ($branchId,$bannerID) {
            $query->whereNotIn('id', $bannerID) // Banner toàn hệ thống
            ->orWhereIn('id', $branchId); // Banner cho chi nhánh cụ thể
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
        $branchId = $request->branch_id ?? null;
        $rewardPoint = $customer->reward_point ?? 0; // Điểm thưởng của khách hàng (mặc định là 0 nếu không có)

        // Lấy số lượng item mỗi trang (mặc định 10)
        $perPage = $request->input('per_page', 10);

        // Truy vấn danh sách quà tặng
        $gifts = Gift::query();
        if (!empty($customer)){
            $customerRank = CustomerRank::where('contact_number', $request->phone)->first();
            $rankCode = $customerRank->current_rank?? 'than_thiet';
            $rank = MembershipLevel::where('rank', $rankCode)->first();
            if (isset($rank)){
                $gifts = $gifts->where(function ($query) use ($rank){
                    $query->where('rank_id', $rank->id)->orWhere('rank_id', null);
                }); // Lấy quà theo hạng thẻ
            }
        }

        // Nếu có branch_id, chỉ lấy quà còn hàng tại cửa hàng đó
        if ($branchId) {
            $gifts = $gifts->whereHas('giftStocks', function ($query) use ($branchId) {
                $query->where('branch_id', $branchId)->where('quantity', '>', 0);
            });
        }

        $gifts = $gifts->where('is_display', true)->paginate($perPage);

        foreach ($gifts as $item){
            $item->branch_id = $branchId;
        }
        $terms = TermsExchangeGift::first();
        if(empty($terms)){
            $terms = [
                'title' => null,
                'content' => null,
                'active' => 0
            ];
        }
        return response()->json([
            'status' => true,
            'reward_point' => $rewardPoint,
            'data' => $gifts,
            'terms_exchange_gift' => $terms
        ]);
    }

    /**
     * Danh sách chương trình
    */
    public function getPrograms(Request $request)
    {
        $customer = $this->getCustomerByPhone($request->phone);
        $branchName = 'Toàn Hệ Thống';
        if (isset($customer->branch_id)){
            $branch = Branch::where('kiotviet_id', $customer->branch_id)->first();
            if (isset($branch)){
                $branchId = ProgramBranch::where('branch_id', $branch->id)->pluck('program_id')->toArray();
                $branchName = $branch->branch_name;
            }else{
                $branchId = [];
            }
        }else{
            $branchId = [];
        }
        $perPage = $request->input('per_page', 10);
        $programID = ProgramBranch::pluck('program_id')->toArray();
        $programs = Program::where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', now());
            })
            ->where(function ($query) use ($branchId, $programID) {
                $query->whereNotIn('id', $programID)->orWhereIn('id', $branchId);
            })
            ->orderByDesc('priority')
            ->orderBy('start_date', 'asc')
            ->paginate($perPage);

        $programs->getCollection()->transform(function ($program) use ($branchName) {
            return [
                'id' => $program->id,
                'title' => $program->title,
                'description' => $program->description,
                'branch_id' => $program->branch_id,
                'branch_name' => $branchName,
                'thumbnail' => $program->thumbnail,
                'images' => json_decode($program->images),
                'start_time' => $program->start_date,
                'end_time' => $program->end_date,
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
        foreach ($promotion as $k => $item){
            $promotion[$k]->apply_to = optional($item->branch)->branch_name ?? 'Toàn hệ thống';
        }

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

//            $this->syncCustomerInvoices($phone);

            $data_return = $this->getMembershipLevel($phone);
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
     * Trả về hạng thành viên của khách hàng
    */
    public function getMembershipLevel($phone){
        try{

            // Tìm khách hàng theo số điện thoại
            $customer = Customer::where('contact_number', $phone)->first();
            if (!$customer) {
                $currentRank = MembershipLevel::where('rank', 'than_thiet')->first();
                // Tìm hạng tiếp theo cần thăng
                $nextRank = MembershipLevel::where('spending_threshold', '>', 0)
                    ->orderBy('spending_threshold', 'asc')
                    ->first();
                // Nếu không còn hạng cao hơn
                $amountNeeded = $nextRank ? max(0, $nextRank->spending_threshold - 0) : 0;

                $data_return = [
                    'customer_name'   => $customer->name ?? null,
                    'phone'           => $phone,
                    'current_rank'    => $currentRank->name ?? 'Thân Thiết',
                    'current_rank_code'    => $currentRank->rank ?? 'than_thiet',
                    'image' => $currentRank->image??null,
                    'total_spent'     => 0,
                    'next_rank'       => $nextRank->name ?? null,
                    'amount_to_next'  => $amountNeeded,
                    'customer_code' => $customer->code??null,
                    'customer_id' => $customer->id??null
                ];

                return $data_return;
            }

            // Thay đổi cập nhật và tạo hạng thành viên
            $typeRank = TypeRankModel::first()->type ?? 1;
            if ($typeRank == 1){
                // Lấy tổng chi tiêu của khách hàng
                $totalSpent = CustomerSpendingSummary::where('contact_number', $phone)->sum('total_spent');
            }else{
                $totalSpent = $customer->reward_point;
            }

            $membershipLevels = MembershipLevel::orderBy('spending_threshold', 'desc')->get();

            // Xác định hạng thẻ phù hợp
            $newRank = null;
            foreach ($membershipLevels as $level) {
                if ($totalSpent >= $level->spending_threshold) {
                    $newRank = $level->rank;
                    break;
                }
            }
            if (!$newRank) {
                $newRank = 'than_thiet';
            }

            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            // Cập nhật hoặc tạo mới hạng thẻ trong customer_ranks
            CustomerRank::updateOrCreate(
                ['contact_number' => $phone],
                [
                    'customer_id' => $customer->kiotviet_id,
                    'current_rank'    => $newRank,
                    'rank_start_date' => Carbon::create($year, $month, 1), // Đầu tháng
                    'rank_end_date'   => Carbon::create($year, $month, 1)->endOfMonth(), // Cuối tháng
                ]
            );
            // Hết thay code

            // Lấy hạng thẻ hiện tại
            $currentRank = CustomerRank::where('contact_number', $phone)->first();
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
                'image' => $currentRank->image??null,
                'total_spent'     => $totalSpent,
                'next_rank'       => $nextRank->name ?? null,
                'amount_to_next'  => $amountNeeded,
                'customer_code' => $customer->code,
                'customer_id' => $customer->id
            ];

            return $data_return;
        }catch (\Exception $exception){

        }
    }

    /**
     * Danh sách voucher
    */
    public function getVouchers(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $vouchers = Voucher::where('expiry_date', '>=', now())
            ->whereNotNull('release_code')
            ->orderBy('expiry_date', 'asc')
            ->paginate($perPage);
        foreach ($vouchers as $voucher){

            $release_code = json_decode($voucher->release_code, true);
            $codes = array_column($release_code, 'code');

            $voucher->branches = Branch::select('id', 'kiotviet_id', 'branch_name', 'account_code')->whereIn('account_code', $codes)->where('is_active', 1)->get();
        }

        return response()->json([
            'status' => true,
            'data' => $vouchers
        ]);
    }

    /**
     * Danh sách mini game
    */
    public function getActiveMiniGames(Request $request)
    {
        $branchId = $request->input('branch_id');

        $miniGames = MiniGame::where('status', 'active')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where(function ($query) use ($branchId) {
                $query->whereNull('branch_id') // Game toàn hệ thống
                ->orWhere('branch_id', $branchId); // Game áp dụng cho chi nhánh cụ thể
            })
            ->get();

        // Duyệt qua từng mini game để tính thời gian còn lại
        foreach ($miniGames as $game) {
            $now = now();
            $endTime = \Carbon\Carbon::parse($game->end_time);
            $diffInDays = floor($now->diffInDays($endTime)); // Chỉ lấy số nguyên

            // Xác định text thời gian còn lại
            if ($now->greaterThanOrEqualTo($endTime)) {
                $game->time_left = "Đã kết thúc";
            } elseif ($diffInDays == 0) {
                $diffInHours = floor($now->diffInHours($endTime));
                $game->time_left = "Thời gian: Chỉ còn $diffInHours giờ";
            } else {
                $game->time_left = "Thời gian: Chỉ còn $diffInDays ngày";
            }
        }

        return response()->json(['status' => true, 'data' => $miniGames], 200);
    }

    /**
     * Liên hệ
    */
    public function getContacts(){

        $data = Contacts::all();

        //Ghi log đếm số lượng truy cập liên hệ & phản hồi
        DailyActivitySummary::logAction(null, 'feedback');

        return response()->json(['status' => true, 'data' => $data], 200);
    }

    /**
     * Slogan
    */
    public function getSlogans(){

        $data = Slogan::find(1);
        $name = Slogan::find(2);

        return response()->json(['status' => true, 'data' => $data, 'name' => $name], 200);
    }
}
