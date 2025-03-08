<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Admin\SyncController;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\EventsModel;
use App\Models\ExchangeGiftEvent;
use App\Models\GiftEvent;
use App\Models\HistoryPointEvent;
use App\Models\QuantityGiftEvents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class EventsController extends SyncController
{
    public function getDataCustomer (Request $request)
    {
        $events = EventsModel::whereDate('time_start', '<=', Carbon::now())->whereDate('time_end', '>=', Carbon::now())->get();
        $customerID = null;
        $branchDefault = Branch::first();
        $branch_id = $request->get('branch_id');
        if (isset($request->phone)){
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $phone = $this->normalizePhone($validatedData['phone']);
            $this->syncCustomerInvoices($phone);
            $customer = Customer::where('contact_number', $phone)->first();
            if (!empty($events) && !empty($customer)){
                foreach ($events as $value){
                    $this->SynchronizePoint($customer->kiotviet_id, $value);
                }
            }
            $customerID = $customer->id??null;
            if (!empty($customer->branch_id) && empty($branch_id)){
                $branchCustomer = Branch::where('kiotviet_id', $customer->branch_id)->first();
                $branch_id = $branchCustomer->id??null;
            }
        }
        if (empty($branch_id)){
            $branch_id = $branchDefault->id;
        }
        foreach ($events as $value){
            $value->images = json_decode($value->images);
        }
        $giftID = QuantityGiftEvents::where('branch_id', $branch_id)->pluck('gift_events_id')->toArray();
        $listGift = GiftEvent::whereIn('id', array_unique($giftID))->where('active', 1)->get();
        foreach ($listGift as $value){
            $quantity = QuantityGiftEvents::where('gift_events_id', $value->id)->where('branch_id', $branch_id)->first();
            $value['quantity'] = $quantity->quantity;
            $branch = Branch::find($branch_id);
            $value['branch_name'] = $branch->branch_name??'';
        }
        $data['events'] = $events;
        $data['customer'] = Customer::find($customerID);
        $data['gifts'] = $listGift;
        return response()->json(['status' => true, 'data' => $data], Response::HTTP_OK);
    }
    /**
     * Đổi quà tặng
    **/
    public function exchangeGift(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $customer = Customer::where('contact_number', $request->get('phone'))->lockForUpdate()->first();
            if (empty($customer)) {
                return response()->json(['status' => false, 'msg' => 'Quý khách không đủ điểm để đổi phần quà này. Vui lòng thử lại sau'], Response::HTTP_BAD_REQUEST);
            }

            $pointCustomer = $customer->total_point_event - $customer->used_point_event;
            $gift = GiftEvent::where('id', $request->get('gift_id'))->where('active', 1)->first();
            if (empty($gift)) {
                return response()->json(['status' => false, 'msg' => 'Quà tặng không tồn tại hoặc đã hết. Vui lòng thử lại sau']);
            }
            $branch_id = $request->get('branch_id');
            if (empty($branch_id)){
                $branch = Branch::where('kiotviet_id', $customer->branch_id)->first();
                $branch_id = $branch->id??null;
            }
            $quantity = QuantityGiftEvents::where('gift_events_id', $gift->id)->where('branch_id', $branch_id)->first();
            if (empty($quantity) || $quantity->quantity < 1){
                return response()->json(['status' => false, 'msg' => 'Quà tặng đã hết. Vui lòng thử lại sau']);
            }
            if ($pointCustomer < $gift->point) {
                return response()->json(['status' => false, 'msg' => 'Điểm của quý khách không đủ để đổi phần quà này. Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
            }
            // Thực hiện trao đổi quà
            $exchange = new ExchangeGiftEvent([
                'customer_id' => $customer->kiotviet_id,
                'gift_id' => $gift->id,
                'name_gift' => $gift->name,
                'image_gift' => $gift->image,
                'code_gift' => $gift->code,
                'barcode_gift' => $gift->barcode ?? null,
                'point' => $gift->point,
                'quantity' => 1,
                'status' => 1,
                'branch_id' => $branch_id
            ]);
            $exchange->save();

            // Ghi nhận lịch sử sử dụng điểm
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $history = new HistoryPointEvent([
                'customer_id' => $customer->kiotviet_id,
                'title' => 'Đổi quà sự kiện',
                'code_order' => substr(str_shuffle($characters), 0, 11),
                'product_id' => $gift->id,
                'product_name' => $gift->name,
                'product_code' => $gift->code,
                'point' => $gift->point,
                'type' => 2
            ]);
            $history->save();

            // Cập nhật điểm khách hàng
            $customer->used_point_event += $gift->point;
            $customer->save();

            // Cập nhật số lượng quà tặng
            $gift->quantity -= 1;
            $gift->save();

            return response()->json(['status' => true, 'gift' => $exchange,
                'msg' => 'Đổi quà thành công. Quý khách vui lòng đến cửa hàng gần nhất để nhận quà. Xin chân thành cảm ơn'], Response::HTTP_OK);
        });

        return $result;
    }

    public function historyExchangeGift (Request $request)
    {
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Số điện thoại không tồn tại trên hệ thống.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        $listData = ExchangeGiftEvent::where('customer_id', $customer->kiotviet_id)->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $gift = GiftEvent::find($value->gift_id);
            $value->name_gift = $gift->name??$value->name_gift;
            $value->image_gift = $gift->image ?? $value->image_gift;
            $value->code_gift = $gift->code??$value->code_gift;
            $value->barcode_gift = $gift->barcode??$value->barcode_gift;
        }
        return \response()->json(['status' => true, 'data' => $listData], Response::HTTP_OK);
    }
    /**
     * Cập nhật trạng thái quà tặng
    **/
    public function statusExchangeGift (Request $request)
    {
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Số điện thoại không tồn tại trên hệ thống.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        $exchange = ExchangeGiftEvent::find($request->get('exchange_gift_id'));
        if (empty($exchange)){
            return \response()->json(['status' => false, 'msg' => 'Giữ liệu không tồn tại.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        if ($exchange->customer_id != $customer->kiotviet_id){
            return \response()->json(['status' => false, 'msg' => 'Giữ liệu không tồn tại.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        if ($exchange->status != 1){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng đã được đổi từ trước.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        $exchange->status = 2;
        $exchange->save();
        return \response()->json(['status' => true, 'msg' => 'Thay đổi trạng thái thành công.Xin chân thành cảm ơn quý khách'], Response::HTTP_OK);
    }
    /**
     * Lịch sử điểm của khách hàng
    **/
    public function historyPoint (Request $request)
    {
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Số điện thoại không tồn tại trên hệ thống.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
        $listData = HistoryPointEvent::where('customer_id', $customer->kiotviet_id)->orderBy('created_at', 'desc')->paginate(20);
        return \response()->json(['status' => true, 'data' => $listData], Response::HTTP_OK);
    }
}
