<?php


namespace App\Http\Controllers\Admin;

use App\Models\InvoiceRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceRequestsExport;
use Carbon\Carbon;
use App\Imports\InvoiceRequestsImport;

class InvoicesController extends HelperAdminController
{
    public function indexRequestInvoice(Request $request)
    {
        $listData = $this->listDataInvoicesRequest($request);
        $listData = $listData->paginate(20);
        $totalData = $listData->total();
        return view('request-invoices.index', compact('listData', 'totalData'));
    }

    public function destroyRequestInvoice($id)
    {
        InvoiceRequest::destroy($id);
        return redirect()->route('invoices-request.index')->with('success', 'Xoá thành công!');
    }

    public function exportInvoiceRequest(Request $request)
    {
        $listData = $this->listDataInvoicesRequest($request);
        $listData = $listData->get();

        $month = now()->month;
        $year = now()->year;

        return Excel::download(new InvoiceRequestsExport($listData), "invoices-request-$month-$year.xlsx");
    }

    public function importRequestInvoice(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new InvoiceRequestsImport, $request->file('file'));

        return redirect()->route('invoices-request.index')->with('success', 'Import thành công!');
    }

    /**
     * Dùng chung cho lấy dữ liệu và xuất excel
     * indexRequestInvoice || exportInvoiceRequest
    */
    private function listDataInvoicesRequest($request){

        $listData = InvoiceRequest::query();
        if (!empty($request->status) && ($request->status != 'all')){
            $listData = $listData->where('status', $request->status);
        }

        // Lọc theo ngày từ và ngày đến
        if (!empty($request->from_date) || !empty($request->to_date)) {
            $fromDate = $request->from_date ? Carbon::parse($request->from_date)->startOfDay() : null;
            $toDate = $request->to_date ? Carbon::parse($request->to_date)->endOfDay() : null;
            if ($fromDate && $toDate) {
                $listData->whereBetween('created_at', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $listData->where('created_at', '>=', $fromDate);
            } elseif ($toDate) {
                $listData->where('created_at', '<=', $toDate);
            }
        }

        if ($request->has('key_search') && $request->key_search) {
            $search = $request->key_search;
            $listData->where(function ($q) use ($search) {
                $q->where('invoice_code', 'LIKE', "%$search%")
                    ->orWhere('name', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%")
                    ->orWhere('tax_code', 'LIKE', "%$search%")
                    ->orWhere('company_name', 'LIKE', "%$search%");
            });
        }
        $listData = $listData->orderByRaw('result_url IS NOT NULL')->orderBy('created_at', 'desc');

        return $listData;
    }
}
