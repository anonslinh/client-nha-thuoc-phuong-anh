<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WebsitePharmacistConsultV1Controller extends Controller
{
    public function index()
    {
        $query = DB::table('branches')
            ->select([
                'id',
                'branch_name',
                'contact_number',
                'address',
            ]);

        if (Schema::hasColumn('branches', 'is_active')) {
            $query->where(function ($q) {
                $q->whereNull('is_active')->orWhere('is_active', 1);
            });
            $query->where('branches.id', '!=', 3);
        }

        if (Schema::hasColumn('branches', 'status')) {
            $query->where(function ($q) {
                $q->whereNull('status')->orWhere('status', 1);
            });
        }

        $branches = $query
            ->orderBy('branch_name', 'asc')
            ->get()
            ->map(function ($branch) {
                $branch->display_phone = $branch->contact_number ?: '085 884 5845';
                $branch->tel_phone = $this->formatTelNumber($branch->display_phone);
                $branch->address_text = $branch->address ?: 'Đang cập nhật địa chỉ';
                return $branch;
            });

        return view('website.pharmacist-consult-v1.index', compact('branches'));
    }

    protected function formatTelNumber(?string $phone): string
    {
        $phone = trim((string) $phone);

        if ($phone === '') {
            return '0858845845';
        }

        return preg_replace('/\D+/', '', $phone) ?: '0858845845';
    }
}