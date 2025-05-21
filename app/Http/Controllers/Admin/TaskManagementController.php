<?php


namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\CustomerFollowUp;
use App\Models\CustomerSpendingSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Child;

class TaskManagementController extends HelperAdminController
{
    /**
     * Danh sách khách hàng đã mua sản phẩm theo mã / tên
     * ──────────────────────────────────────────────────
     *  ‑ key_search  : mã hoặc tên sản phẩm (bắt buộc)
     *  ‑ from_days   : số ngày xa nhất (không bắt buộc)
     *  ‑ to_days     : số ngày gần nhất (không bắt buộc)
     *    ▸ Nếu truyền cả from & to  ➜ lọc trong KHOẢNG [to_days ; from_days]
     *    ▸ Nếu chỉ truyền from_days ➜ lọc đúng NGÀY đó (x ngày trước)
     */
    public function indexProductBy(Request $request)
    {
        try {
            /* ───────── Tham số tìm kiếm ───────── */
            $productSearch = trim($request->key_search);
            $fromDays      = is_numeric($request->from_days) ? (int) $request->from_days : null; // xa nhất
            $toDays        = is_numeric($request->to_days)   ? (int) $request->to_days   : null; // gần nhất

            if (!$productSearch) {
                $listData = null;
                return view('crm-customers.task-management', compact('listData'));
            }

            $now = Carbon::now('Asia/Ho_Chi_Minh');

            /* ───────── Sub‑query: lần mua CUỐI mỗi khách hàng ───────── */
            $sub = DB::table('invoice_details as d')
                ->join('invoices as i', 'i.id', '=', 'd.invoice_id')
                ->where(function ($q) use ($productSearch) {
                    $q->where('d.product_code', 'like', $productSearch . '%')
                        ->orWhere('d.product_name', 'like', '%' . $productSearch . '%');
                })
                ->selectRaw('MAX(i.purchase_date) AS last_purchase, i.customer_id')
                ->groupBy('i.customer_id');

            /* ───────── Join lại invoices để lấy đúng hoá đơn cuối ───────── */
            $invoicesQuery = DB::table('invoices as i')
                ->joinSub($sub, 'latest', function ($join) {
                    $join->on('latest.customer_id', '=', 'i.customer_id')
                        ->on('latest.last_purchase', '=', 'i.purchase_date');
                });

            /* ───────── Lọc theo số ngày ───────── */
            if ($fromDays !== null && $toDays !== null) {
                // Khoảng ngày: [to_days ; from_days]
                $start = $now->copy()->subDays($toDays)->startOfDay();
                $end   = $now->copy()->subDays($fromDays)->endOfDay();
                $invoicesQuery->whereBetween('i.purchase_date', [$start, $end]);
            } elseif ($fromDays !== null) {
                // Đúng 1 ngày cụ thể (x ngày trước)
                $target = $now->copy()->subDays($fromDays)->toDateString();
                $invoicesQuery->whereDate('i.purchase_date', $target);
            }

            /* ───────── Lấy dữ liệu cần hiển thị ───────── */
            $listData = $invoicesQuery
                /* Join thêm invoice_details để lấy mã & tên sản phẩm phù hợp */
                ->join('invoice_details as d', function ($join) use ($productSearch) {
                    $join->on('d.invoice_id', '=', 'i.id')
                        ->where(function ($q) use ($productSearch) {
                            $q->where('d.product_code', 'like', $productSearch . '%')
                                ->orWhere('d.product_name', 'like', '%' . $productSearch . '%');
                        });
                })
                ->select([
                    'i.id',
                    'i.customer_id',
                    'i.customer_code',
                    'i.customer_name',
                    'i.contact_number',
                    'i.purchase_date',
                    'i.branch_id',
                    'i.total',
                    'i.code',
                    'i.branch_name',
                    'd.product_code',
                    'd.product_name',
                    'd.quantity',
                    DB::raw('DATEDIFF(CURDATE(), i.purchase_date) AS days_since_purchase')
                ])
                ->orderByDesc('i.purchase_date')
                ->paginate(20);

            return view('crm-customers.task-management', compact('listData'));
        } catch (\Throwable $e) {          // dùng Throwable để bắt cả Error & Exception
            Log::error($e);
            return back()->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    /**
     * Lưu thông tin của con theo khách hàng
    */
    public function storeChildCustomer(Request $request)
    {
        try{
            $dob = null;
            $due_date = $request->date_of_birth;

            if ($request->status == 'born'){
                $dob = $request->date_of_birth;
                $due_date = null;
            }

            Child::create([
                'customer_id' => $request->customer_id,
                'contact_number' => $request->contact_number,
                'name' => $request->name,
                'gender' => $request->gender,
                'status' => $request->status,
                'dob' => $dob,
                'due_date' => $due_date,
            ]);

            return back()->with(['success' => 'Cập nhật thành công!']);
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Tính ngày tháng năm sinh của con
    */
    public function calculateDob(array $data)
    {
        try{
            //Mang bầu
            if ($data['status'] === 'pregnant') {
                // Nhập ngày dự kiến sinh
                if (!empty($data['due_date'])) {
                    return Carbon::parse($data['due_date']);
                }

                // Nhập số tháng mang bầu => còn lại bao nhiêu tháng
                if (!empty($data['gestational_month'])) {
                    $remainingMonths = 9 - (int)$data['gestational_month'];
                    return Carbon::now()->addMonths($remainingMonths);
                }
            }

            // Đã sinh
            if ($data['status'] === 'born') {
                // Nhập ngày tháng năm sinh
                if (!empty($data['dob'])) {
                    return Carbon::parse($data['dob']);
                }

                // Nhập năm tuổi
                if (!empty($data['age_years'])) {
                    return Carbon::now()->subYears((int)$data['age_years']);
                }

                // Nhập tháng tuổi
                if (!empty($data['age_months'])) {
                    return Carbon::now()->subMonths((int)$data['age_months']);
                }
            }

            return null;
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Chi tiết khách hàng
    */
    public function detailCustomer(Request $request, $customer_id)
    {
        try {
            // Lấy khách hàng theo kiotviet_id hoặc báo lỗi 404
            $customer = Customer::where('kiotviet_id', $customer_id)->firstOrFail();

            // Lấy dữ liệu liên quan
            $spending_summary = $this->getSpendingSummaryByContactNumber($customer->contact_number);
            $invoice_details = $this->getInvoiceDetailsByPhone($customer->contact_number);

            $children = Child::where('contact_number', $customer->contact_number)->get();

            $now = Carbon::now();

            // Tính display_info cho từng child
            foreach ($children as $child) {
                $child->display_info = $this->getChildDisplayInfo($child, $now);
            }
            $customer_notes = CustomerFollowUp::where('contact_number', $customer->contact_number)->orderBy('id', 'desc')->get();

            return view('customer.detail-customer', compact('customer', 'spending_summary', 'invoice_details', 'children', 'customer_notes'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Nếu không tìm thấy khách hàng
            return abort(404, 'Khách hàng không tồn tại.');
        } catch (\Exception $exception) {
            // Log lỗi chi tiết
            Log::error('Lỗi detailCustomer: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
                'customer_id' => $customer_id,
            ]);
            // Trả về trang lỗi chung hoặc thông báo lỗi phù hợp
            return back()->withErrors('Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }

    /**
     * Tính display_info cho child dựa trên trạng thái và ngày tháng.
     */
    private function getChildDisplayInfo(Child $child, Carbon $now): string
    {
        if ($child->status === 'pregnant' && $child->due_date) {
            $dueDate = Carbon::parse($child->due_date);
            $startPregnancy = $dueDate->copy()->subWeeks(40);

            if ($now->lt($startPregnancy)) {
                return "Chưa mang thai";
            }

            if ($now->gt($dueDate)) {
                return "Đã sinh";
            }

            $days = $startPregnancy->diffInDays($now);
            $weeks = floor($days / 7);
            $extraDays = $days % 7;

            return "Đang mang thai tuần thứ {$weeks}" . ($extraDays > 0 ? " + {$extraDays} ngày" : "");
        }

        if ($child->dob) {
            $dob = Carbon::parse($child->dob);
            $diff = $dob->diff($now);
            $years = $diff->y;
            $months = $diff->m;

            if ($years === 0) {
                return "{$months} tháng tuổi";
            }

            return "{$years} tuổi" . ($months > 0 ? " {$months} tháng" : '');
        }

        // Trường hợp không có dob hoặc due_date
        return "Thông tin chưa đầy đủ";
    }

    /**
     * Danh sách sản phẩm khách hàng đã mua
    */
    public function getInvoiceDetailsByPhone(string $contactNumber){
        try{
            $items = DB::table('invoice_details as d')
                ->join('invoices as i', 'i.id', '=', 'd.invoice_id')
                ->where('i.contact_number', $contactNumber)
                ->select([
                    'd.*',
                    'i.branch_name',
                    'i.sold_by_name',
                    'i.created_date',
                    DB::raw('DATEDIFF(CURDATE(), i.created_date) AS days_since_purchase')
                ])
                ->orderBy('i.created_date', 'desc') // ✅ sắp xếp mới nhất trước
                ->get();
            return $items;
        }catch (\Exception $exception){
            dd($exception);
        }
    }

    /**
     * Danh sách chi tiêu theo tháng của khách hàng
    */
    private function getSpendingSummaryByContactNumber(string $contactNumber)
    {
        try {
            $startMonth = Carbon::now()->subMonths(6)->startOfMonth();
            $endMonth   = Carbon::now()->endOfMonth();

            $raw = CustomerSpendingSummary::where('contact_number', $contactNumber)
                ->whereRaw("STR_TO_DATE(CONCAT(year,'-',LPAD(month,2,'0'),'-01'), '%Y-%m-%d') BETWEEN ? AND ?",
                    [$startMonth->toDateString(), $endMonth->toDateString()])
                ->selectRaw('year, month, SUM(total_spent) AS total_spent')
                ->groupBy('year', 'month')
                ->get()
                ->mapWithKeys(function ($item) {
                    $key = sprintf('%04d-%02d', $item->year, $item->month); // YYYY-MM
                    return [$key => (float) $item->total_spent];
                });

            $labels = [];
            $series = [];

            for ($date = $startMonth->copy(); $date->lte($endMonth); $date->addMonth()) {
                $key      = $date->format('Y-m');
                $labels[] = $date->format('m/Y');
                $amount   = $raw[$key] ?? 0;
                $series[] = $amount;
            }

            return [
                'months' => $labels,
                'series' => [
                    [
                        'name' => 'Tổng chi tiêu',
                        'data' => $series
                    ]
                ]
            ];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Xoá thông tin con
    */
    public function deleteChild($child_id){
        try{
            $child = Child::findOrFail($child_id);
            $child->delete();

            return back()->with('success', 'Xoá thông tin con thành công.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return back()->withErrors('Không tìm thấy thông tin con cần xoá.');

        }

    }

    /**
     * Lưu ghi chú
    */
    public function storeCustomerNote(Request $request){
        try{

            $customer_note = new CustomerFollowUp();
            $customer_note->customer_id = $request->customer_id;
            $customer_note->contact_number = $request->contact_number;
            $customer_note->schedule_date = $request->schedule_date;
            $customer_note->note = $request->note;

            $customer_note->save();

            return back()->with(['success' => 'Cập nhật thành công!']);

        } catch (\Exception $exception) {
            // Trả về trang lỗi chung hoặc thông báo lỗi phù hợp
            return back()->withErrors('Đã xảy ra lỗi, vui lòng thử lại sau.');
        }
    }
}
