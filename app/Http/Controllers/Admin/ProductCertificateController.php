<?php


namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\ProductCertificate;
use App\Exports\ProductCertificateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductCertificateImport;


class ProductCertificateController extends HelperAdminController
{
    public function indexCertificates(Request $request)
    {
        $listData = ProductCertificate::query();

        if ($request->has('key_search') && $request->key_search) {
            $search = $request->key_search;
            $listData->where(function ($q) use ($search) {
                $q->where('product_name', 'LIKE', "%$search%")
                    ->orWhere('product_code', 'LIKE', "%$search%");
            });
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        $totalCertificates = $listData->total();
        return view('certificates.index', compact('listData', 'totalCertificates'));
    }

    public function storeCertificates(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'product_code' => 'required|string|unique:product_certificates,product_code',
            'certificate_link' => 'required|url',
        ]);

        ProductCertificate::create($request->all());
        return redirect()->route('certificates.index')->with('success', 'Thêm giấy chứng nhận thành công');
    }

    public function updateCertificates(Request $request, $id)
    {
        $certificate = ProductCertificate::findOrFail($id);

        $request->validate([
            'product_name' => 'required|string',
            'product_code' => 'required|string|unique:product_certificates,product_code,' . $id,
            'certificate_link' => 'required|url',
        ]);

        $certificate->update($request->all());
        return redirect()->route('certificates.index')->with('success', 'Cập nhật giấy chứng nhận thành công');
    }

    public function destroyCertificates($id)
    {
        ProductCertificate::destroy($id);
        return redirect()->route('certificates.index')->with('success', 'Xoá giấy chứng nhận thành công');
    }

    public function exportCertificates()
    {
        $month = now()->month;
        $year = now()->year;
        return Excel::download(new ProductCertificateExport, "certificates-$month-$year.xlsx");
    }

    public function importCertificates(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new ProductCertificateImport, $request->file('file'));

        return redirect()->route('certificates.index')->with('success', 'Import thành công!');
    }

}
