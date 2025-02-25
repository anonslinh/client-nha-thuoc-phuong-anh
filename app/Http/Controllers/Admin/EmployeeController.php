<?php


namespace App\Http\Controllers\Admin;


use App\Models\Employee;
use App\Models\EmployeeKpi;
use App\Models\InvoiceRating;
use Illuminate\Http\Request;
use App\Exports\EmployeeRatingsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmployeeRatingSummary;

class EmployeeController extends HelperAdminController
{
    /**
     * Danh sách nhân viên
    */
    public function getEmployees(Request $request)
    {
        $month = now()->month;
        $year = now()->year;

        // Khởi tạo query danh sách nhân viên
        $query = Employee::query();

        // Tìm kiếm theo key_search (user_name, given_name, address)
        if ($request->has('key_search') && $request->key_search) {
            $search = $request->key_search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'LIKE', "%$search%")
                    ->orWhere('given_name', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%");
            });
        }

        // Lấy điểm KPI trong tháng (nếu không có thì mặc định là 70)
        $query->leftJoin('employee_kpis', function ($join) use ($month, $year) {
            $join->on('employees.kiotviet_id', '=', 'employee_kpis.kiotviet_employee_id')
                ->where('employee_kpis.month', $month)
                ->where('employee_kpis.year', $year);
        })->select('employees.*', \DB::raw('COALESCE(employee_kpis.points, 70) as kpi_points'));

        // Lấy tổng số đánh giá dưới 3 sao trong tháng
        $query->leftJoin('employee_rating_summaries', function ($join) use ($month, $year) {
            $join->on('employees.kiotviet_id', '=', 'employee_rating_summaries.employee_id')
                ->where('employee_rating_summaries.month', $month)
                ->where('employee_rating_summaries.year', $year);
        })->selectRaw('COALESCE(employee_rating_summaries.rating_1, 0) + COALESCE(employee_rating_summaries.rating_2, 0) + COALESCE(employee_rating_summaries.rating_3, 0) as low_ratings');


        // Lọc theo khoảng điểm KPI
        if ($request->has('filter_kpi') && $request->filter_kpi != 'all') {
            switch ($request->filter_kpi) {
                case '30_50':
                    $query->whereRaw('COALESCE(employee_kpis.points, 70) BETWEEN ? AND ?', [30, 50]);
                    break;
                case '50_70':
                    $query->whereRaw('COALESCE(employee_kpis.points, 70) BETWEEN ? AND ?', [51, 70]);
                    break;
                case '70_90':
                    $query->whereRaw('COALESCE(employee_kpis.points, 70) BETWEEN ? AND ?', [71, 90]);
                    break;
                case '90_120':
                    $query->whereRaw('COALESCE(employee_kpis.points, 70) BETWEEN ? AND ?', [91, 120]);
                    break;
                case 'above_120':
                    $query->whereRaw('COALESCE(employee_kpis.points, 70) > ?', [120]);
                    break;
            }
        }




        // Tách riêng sắp xếp theo KPI và sắp xếp theo đánh giá dưới 3 sao
        if ($request->has('sort_kpi')) {
            if ($request->sort_kpi === 'high') {
                $query->orderByDesc('kpi_points'); // Sắp xếp KPI cao nhất
            } elseif ($request->sort_kpi === 'low') {
                $query->orderBy('kpi_points'); // Sắp xếp KPI thấp nhất
            }
        }

        if ($request->has('sort_ratings')) {
            if ($request->sort_ratings === 'high') {
                $query->orderByDesc('low_ratings'); // Sắp xếp tổng đánh giá thấp cao nhất
            } elseif ($request->sort_ratings === 'low') {
                $query->orderBy('low_ratings'); // Sắp xếp tổng đánh giá thấp thấp nhất
            }
        }


        // Lấy dữ liệu phân trang
        $listData = $query->paginate(20);
        $totalEmployees = $listData->total(); // Tổng số nhân viên

        return view('employee.employees', compact('listData', 'totalEmployees'));
    }

    /**
     * Chi tiết đánh giá nhân viên
    */
    public function getEmployeeDetails(Request $request, $employeeId)
    {
        try{

            $month = now()->month;
            $year = now()->year;

            // Tạo danh sách 6 tháng tiếp theo
            $data_months = $this->getMonths($month, $year, $employeeId);
            $months = $data_months['months'];
            // Tạo dữ liệu series cho biểu đồ
            $chartSeries = [
                [
                    "name" => "⭐ Nguy hiểm",
                    "data" => $data_months['low_ratings_data'],
                ],
                [
                    "name" => "Điểm",
                    "data" => $data_months['kpi_data'],
                ],
            ];
            // Lấy điểm KPI nhân viên (mặc định là 70 nếu không có)
            $points = EmployeeKpi::where('kiotviet_employee_id', $employeeId)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->value('points') ?? 70;

            // Truy vấn thông tin nhân viên
            $employee = Employee::where('kiotviet_id', $employeeId)->first();

            $query = InvoiceRating::with(['invoice:id,kiotviet_id,code,created_date'])
                ->where('employee_id', $employeeId)
                ->orderBy('created_at', 'desc');

            // Lọc theo ngày từ và ngày đến
            if (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date) && !empty($request->to_date)) {
                    $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
                } elseif (!empty($request->from_date)) {
                    $query->where('created_at', '>=', $request->from_date);
                } elseif (!empty($request->to_date)) {
                    $query->where('created_at', '<=', $request->to_date);
                }
            }

            // Lọc theo số lượng sao (rating)
            if ($request->has('rating') && in_array($request->rating, [1, 2, 3, 4, 5])) {
                $query->where('rating', $request->rating);
            }

            $listData = $query->paginate(20);

            return view('employee.employee-detail', compact('employee', 'listData', 'points', 'months', 'chartSeries'));
        }catch (\Exception $exception){
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phận CSKH']);
        }
    }

    /**
     * Xuất excel đánh giá nhân viên
    */
    public function exportEmployeeRatings(Request $request, $employeeId)
    {
        try {
            // Truy vấn thông tin nhân viên
            $employee = Employee::where('kiotviet_id', $employeeId)->first();

            $query = InvoiceRating::with(['invoice:id,kiotviet_id,code,created_date'])
                ->where('employee_id', $employeeId)
                ->orderByDesc('created_at');

            // Lọc theo ngày từ và ngày đến
            if (!empty($request->from_date) || !empty($request->to_date)) {
                $fromDate = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : null;
                $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;

                if ($fromDate && $toDate) {
                    $query->whereBetween('created_at', [$fromDate, $toDate]);
                } elseif ($fromDate) {
                    $query->where('created_at', '>=', $fromDate);
                } elseif ($toDate) {
                    $query->where('created_at', '<=', $toDate);
                }
            }

            // Lọc theo số lượng sao (rating)
            if ($request->has('rating') && in_array($request->rating, [1, 2, 3, 4, 5])) {
                $query->where('rating', $request->rating);
            }

            // **Lấy dữ liệu 6 tháng trước đó**
            $month = now()->month;
            $year = now()->year;
            $historyData = $this->getMonths($month, $year, $employeeId);

            // **Xuất Excel với dữ liệu đầy đủ**
            return Excel::download(new EmployeeRatingsExport($query, $employee, $historyData), "{$employee->user_name}_ratings.xlsx");
        } catch (\Exception $exception) {
            return back()->with(['error' => 'Lỗi xuất Excel! Liên hệ với bộ phận CSKH']);
        }
    }

    /**
     * Lấy danh sách 6 tháng trước đó tính từ tháng hiện tại
    */
    private function getMonths($month, $year, $employeeId){
        $months = [];
        $kpiData = [];
        $lowRatingsData = [];

        for ($i = 0; $i < 6; $i++) {
            // Thêm vào danh sách tháng
            $months[] = "T " . $month . "/" . $year;

            // Lấy điểm KPI của nhân viên (mặc định là 70 nếu không có)
            $kpiPoints = EmployeeKpi::where('kiotviet_employee_id', $employeeId)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->value('points') ?? 70;
            $kpiData[] = $kpiPoints;

            // Lấy tổng số đánh giá dưới 3 sao
            $lowRatings = EmployeeRatingSummary::where('employee_id', $employeeId)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->selectRaw('COALESCE(rating_1, 0) + COALESCE(rating_2, 0) + COALESCE(rating_3, 0) as low_ratings')
                    ->value('low_ratings') ?? 0;
            $lowRatingsData[] = $lowRatings;

            // Lùi về tháng trước
            $month--;
            if ($month == 0) {
                $month = 12;
                $year--;
            }
        }

        // Đảo ngược mảng để hiển thị từ xa đến gần
        $months = array_reverse($months);
        $kpiData = array_reverse($kpiData);
        $lowRatingsData = array_reverse($lowRatingsData);

        return $data = [
            'months' => $months,
            'kpi_data' => $kpiData,
            'low_ratings_data' => $lowRatingsData
        ];
    }


    /**
     * Đánh giá hoá đơn
     */
    public function getRatingsInvoice(Request $request)
    {
        try{

            $month = now()->month;
            $year = now()->year;

            // Tạo danh sách 6 tháng tiếp theo
            $data_months = $this->getMonthsRatingsInvoice($month, $year);
            $months = $data_months['months'];
            // Tạo dữ liệu series cho biểu đồ
            $chartSeries = [
                [
                    "name" => "⭐",
                    "data" => $data_months['ratings']['rating_1'],
                ],
                [
                    "name" => "⭐⭐",
                    "data" => $data_months['ratings']['rating_2'],
                ],
                [
                    "name" => "⭐⭐⭐",
                    "data" => $data_months['ratings']['rating_3'],
                ],
                [
                    "name" => "⭐⭐⭐⭐",
                    "data" => $data_months['ratings']['rating_4'],
                ],
                [
                    "name" => "⭐⭐⭐⭐⭐",
                    "data" => $data_months['ratings']['rating_5'],
                ],
            ];

            $query = InvoiceRating::with(['invoice' => function ($query) {
                $query->select('id', 'kiotviet_id', 'code', 'total_payment', 'sold_by_name', 'branch_name');
            }])
                ->orderByDesc('created_at');

            // Lọc theo ngày từ và ngày đến
            if (!empty($request->from_date) || !empty($request->to_date)) {
                if (!empty($request->from_date) && !empty($request->to_date)) {
                    $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
                } elseif (!empty($request->from_date)) {
                    $query->where('created_at', '>=', $request->from_date);
                } elseif (!empty($request->to_date)) {
                    $query->where('created_at', '<=', $request->to_date);
                }
            }

            // Lọc theo số lượng sao (rating)
            if ($request->has('rating') && in_array($request->rating, [1, 2, 3, 4, 5])) {
                $query->where('rating', $request->rating);
            }

            $listData = $query->paginate(20);

            return view('employee.ratings-invoice', compact( 'listData', 'months', 'chartSeries'));
        }catch (\Exception $exception){
            dd($exception);
            return back()->with(['error' => 'Lỗi! Liên hệ với bộ phận CSKH']);
        }
    }

    /**
     * Lấy danh sách 6 tháng trước đó tính từ tháng hiện tại
     */
    private function getMonthsRatingsInvoice($month, $year) {
        $months = [];
        $ratings = [
            'rating_1' => [],
            'rating_2' => [],
            'rating_3' => [],
            'rating_4' => [],
            'rating_5' => []
        ];

        for ($i = 0; $i < 6; $i++) {
            // Thêm vào danh sách tháng
            $months[] = "T " . $month . "/" . $year;

            // Lấy tổng số đánh giá từ 1 đến 5 sao
            $ratingData = EmployeeRatingSummary::where('month', $month)
                ->where('year', $year)
                ->selectRaw('
                COALESCE(SUM(rating_1), 0) as rating_1,
                COALESCE(SUM(rating_2), 0) as rating_2,
                COALESCE(SUM(rating_3), 0) as rating_3,
                COALESCE(SUM(rating_4), 0) as rating_4,
                COALESCE(SUM(rating_5), 0) as rating_5
            ')
                ->first();

            foreach ($ratings as $key => &$ratingArray) {
                $ratingArray[] = $ratingData ? $ratingData->$key : 0;
            }

            // Lùi về tháng trước
            $month--;
            if ($month == 0) {
                $month = 12;
                $year--;
            }
        }

        // Đảo ngược mảng để hiển thị từ xa đến gần
        $months = array_reverse($months);
        foreach ($ratings as &$ratingArray) {
            $ratingArray = array_reverse($ratingArray);
        }

        return [
            'months' => $months,
            'ratings' => $ratings
        ];
    }

}
