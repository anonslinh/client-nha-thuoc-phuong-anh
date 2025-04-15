<?php


namespace App\Http\Controllers\Admin;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Prescription;


class PharmacyController extends HelperAdminController
{
    public function indexPrescription(Request $request)
    {
        $query = Prescription::query();

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        if ($request->has('key_search') && $request->key_search) {
            $search = $request->key_search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%")
                    ->orWhere('address', 'LIKE', "%$search%");
            });
        }

        $listData = $query
            ->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->orderByDesc('created_at')
            ->paginate(20);
        $total = $listData->total();
        return view('pharmacy.perscriptions', compact('listData', 'total'));
    }

    public function showPrescription(Request $request, $id){
        $data = Prescription::findOrFail($id);
        $phone = $data->phone;
        if (!empty($request->phone) && ($request->phone != $data->phone)){

        }
        $invoices = Invoice::where('contact_number', $phone)->with('details')->orderBy('created_date')->get();

        return view('pharmacy.prescription-detail', compact('data', 'invoices'));
    }
}
