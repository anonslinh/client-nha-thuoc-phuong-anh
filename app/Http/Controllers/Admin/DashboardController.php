<?php


namespace App\Http\Controllers\Admin;
use App\Models\Customer;
use App\Models\DailyActivitySummary;
use App\Models\Employee;
use App\Models\GiftExchanges;
use App\Models\InvoiceRating;
use App\Models\VoucherExchanges;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends HelperAdminController
{
    /**
     * Dữ liệu thống kê
    */
    public function index ()
    {
        $activity_summary = $this->getActivitySummary();
        $user = Auth::guard('users')->user();
        $ratings = $this->getLowRatingInvoices();
        $employees = $this->getEmployees();
        $customers = $this->getCustomer();
        $totalCustomers = Customer::count(); // Tổng số khách hàng
        $totalAccess = DailyActivitySummary::where('action', 'access_to')->sum('count');
        $voucher_exchange = VoucherExchanges::whereIn('status', ['pending', 'completed'])->count();
        $gift_exchange = GiftExchanges::whereIn('status', ['pending', 'completed'])->count();

        return view('dashboard', compact('activity_summary', 'user', 'ratings', 'employees', 'customers', 'totalAccess',
            'totalCustomers', 'voucher_exchange', 'gift_exchange'));
    }

    /**
     * Dữ liệu khách hàng truy cập ứng dụng
    */
    private function getActivitySummary()
    {
        try{

            $startDate = Carbon::today()->subDays(6); // Lấy ngày bắt đầu (7 ngày trước)
            $dates = [];
            $activityData = [];

            // Khởi tạo mảng rỗng cho từng loại hành động
            $actions = ['access_to' => 'Truy cập', 'view_points' => 'Xem điểm', 'redeem_gift_voucher' => 'Đổi quà voucher', 'rate' => 'Đánh giá', 'follow_oa' => 'Follow OA'];
            foreach ($actions as $key => $label) {
                $activityData[$key] = ['name' => $label, 'data' => []];
            }

            // Lặp qua 7 ngày gần nhất
            for ($date = $startDate; $date <= Carbon::today(); $date->addDay()) {
                $dates[] = $date->format('d/m/Y');

                // Truy vấn dữ liệu theo ngày và nhóm theo action
                $dailyStats = DailyActivitySummary::where('date', $date->toDateString())
                    ->selectRaw('action, SUM(count) as total')
                    ->groupBy('action')
                    ->pluck('total', 'action')
                    ->toArray();

                // Đổ dữ liệu vào từng hành động
                foreach ($actions as $key => $label) {
                    $activityData[$key]['data'][] = $dailyStats[$key] ?? 0; // Nếu không có dữ liệu thì mặc định là 0
                }
            }

            $data_return = [
                'dates' => $dates,
                'series' => array_values($activityData) // Chuyển về dạng mảng để hiển thị đúng format
            ];

            return $data_return;

        }catch (\Exception $exception){
            return [];
        }
    }

    /**
     * Danh sách đánh giá dưới 3 sao
    */
    private function getLowRatingInvoices($limit = 10)
    {
        $today = Carbon::today()->toDateString(); // Lấy ngày hôm nay

        $ratings = InvoiceRating::whereDate('created_at', $today)
            ->where('rating', '<=', 3) // Chỉ lấy đánh giá từ 3 sao trở xuống
            ->with(['invoice' => function ($query) {
                $query->select('id', 'kiotviet_id', 'code', 'total_payment', 'sold_by_name', 'branch_name');
            }])
            ->orderByDesc('created_at') // Sắp xếp theo thời gian mới nhất
            ->limit($limit) // Giới hạn số lượng kết quả
            ->get();

        return $ratings;
    }

    /**
     * Danh sách nhân viên bị cảnh báo
    */
    private function getEmployees()
    {
        $month = now()->month;
        $year = now()->year;

        // Lấy danh sách nhân viên có KPI dưới 60 điểm
        $employees = Employee::leftJoin('employee_kpis', function ($join) use ($month, $year) {
            $join->on('employees.kiotviet_id', '=', 'employee_kpis.kiotviet_employee_id')
                ->where('employee_kpis.month', $month)
                ->where('employee_kpis.year', $year);
        })
            ->leftJoin('employee_rating_summaries', function ($join) use ($month, $year) {
                $join->on('employees.kiotviet_id', '=', 'employee_rating_summaries.employee_id')
                    ->where('employee_rating_summaries.month', $month)
                    ->where('employee_rating_summaries.year', $year);
            })
            ->select(
                'employees.*',
                \DB::raw('COALESCE(employee_kpis.points, 70) as kpi_points'),
                \DB::raw('COALESCE(employee_rating_summaries.rating_1, 0) + COALESCE(employee_rating_summaries.rating_2, 0) + COALESCE(employee_rating_summaries.rating_3, 0) as low_ratings')
            )
            ->having('kpi_points', '<', 60) // Chỉ lấy nhân viên có KPI dưới 60
            ->orderBy('kpi_points', 'asc') // Sắp xếp tăng dần theo điểm KPI
            ->limit(10) // Giới hạn 10 bản ghi
            ->get();

        return $employees;
    }

    /**
     * Danh sách khách hàng
    */
    private function getCustomer()
    {
        $today = now()->toDateString();

        // Lấy danh sách khách hàng có đơn hàng trong ngày hôm nay
        $customers = Customer::leftJoin('invoices', 'customers.kiotviet_id', '=', 'invoices.customer_id')
            ->whereDate('customers.created_at', $today) // Chỉ lấy đơn hàng của ngày hôm nay
            ->select(
                'customers.id', 'customers.code', 'customers.name', 'customers.contact_number', 'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points',
                \DB::raw('COUNT(invoices.id) as total_orders') // Tổng số đơn hàng trong ngày
            )
            ->groupBy('customers.id', 'customers.code', 'customers.name', 'customers.contact_number', 'customers.total_revenue', 'customers.kiotviet_reward_point', 'customers.used_points') // Nhóm theo khách hàng
            ->orderByDesc('total_orders') // Sắp xếp theo số đơn hàng giảm dần
            ->limit(10) // Lấy 10 bản ghi
            ->get();

        return $customers;
    }

}
