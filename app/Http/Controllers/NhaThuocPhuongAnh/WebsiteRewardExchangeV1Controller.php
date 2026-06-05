<?php

namespace App\Http\Controllers\NhaThuocPhuongAnh;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebsiteRewardExchangeV1Controller extends Controller
{
    public function index(Request $request)
    {
        $guestCheckoutInfo = session('guest_checkout_info', []);

        $initialPhone = trim((string) ($guestCheckoutInfo['customer_phone'] ?? ''));
        $initialName = trim((string) ($guestCheckoutInfo['customer_name'] ?? ''));

        return view('website.reward-exchange-v1.index', compact(
            'guestCheckoutInfo',
            'initialPhone',
            'initialName'
        ));
    }
}