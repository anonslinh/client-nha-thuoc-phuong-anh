<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsitePurchasedMedicineV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', []);

        $initialPhone = trim((string) ($guestCheckoutInfo['customer_phone'] ?? ''));

        return view('website.purchased-medicine-v1.index', compact(
            'guestCheckoutInfo',
            'initialPhone'
        ));
    }
}