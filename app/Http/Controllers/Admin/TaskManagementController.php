<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
}
