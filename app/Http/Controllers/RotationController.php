<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\HelperAdminController;
use App\Models\Customer;
use App\Models\GiftRotation;
use App\Models\HistoryGiftRotation;
use App\Models\HistoryInvoiceRotation;
use App\Models\RotationModel;
use App\Models\RuleRotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RotationController extends HelperAdminController
{
    public function setting (Request $request)
    {
        $rotation = RotationModel::first();
        $dataRule = [];
        if (!empty($rotation)){
           $dataRule = $rotation->DataRuleRotation;
        }
        return view('rotation.index', compact('rotation', 'dataRule'));
    }

    public function create (Request $request)
    {
        $rotation = RotationModel::first();
        if (empty($rotation)){
            $rotation = new RotationModel([
                'title' => $request->get('title'),
                'time_start' => $request->get('time_start'),
                'time_end' => $request->get('time_end')
            ]);
        }else{
            $rotation->title = $request->get('title');
            $rotation->time_start = $request->get('time_start');
            $rotation->time_end = $request->get('time_end');
        }
        $rotation->save();
        foreach ($request->get('data') as $value){
            if (isset($value['rule_id'])){
                $rule_rotation = RuleRotation::find($value['rule_id']);
                if (isset($rule_rotation)){
                    $rule_rotation->money_invoice_1 = $value['money_invoice_1'];
                    $rule_rotation->money_invoice_2 = $value['money_invoice_2'];
                    $rule_rotation->save();
                }
            }else{
                $rule_rotation = new RuleRotation([
                    'rotation_id' => $rotation['id'],
                    'money_invoice_1' => $value['money_invoice_1'],
                    'money_invoice_2' => $value['money_invoice_2'],
                ]);
                $rule_rotation->save();
            }
        }
        return back()->with(['success' => 'Cập nhật vòng quay thành công']);
    }
    public function delete ()
    {
        $rotation = RotationModel::first();
        if (isset($rotation)){
            $rotation->delete();
        }
        return back()->with(['success' => 'Reset dữ liệu thành công']);
    }
    public function gift (Request $request)
    {
        $listData = GiftRotation::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        if (isset($request->rule_rotation_id)){
            $listData = $listData->where('rule_rotation_id', $request->get('rule_rotation_id'));
        }
        $listData = $listData->paginate(20);
        $rule_rotation = RuleRotation::all();
        return view('rotation.gift', compact('listData', 'rule_rotation'));
    }
    public function createGift (Request $request)
    {
        try{
            if (!$request->hasFile('image')){
                return back()->with(['error' => 'Vui lòng thêm hình ảnh quà tặng']);
            }
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            $gift = new GiftRotation([
                'title' => $request->get('title'),
                'code' => $request->get('code'),
                'quantity' => $request->get('quantity'),
                'percent' => $request->get('percent') / 100,
                'rule_rotation_id' => $request->get('rule_rotation_id'),
                'image' => $image
            ]);
            $gift->save();
            return back()->with(['success' => 'Cấu hình quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại']);
        }
    }
    public function updateGift (Request $request, $id)
    {
        $gift = GiftRotation::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            if (file_exists(public_path($gift->image))) {
                unlink(public_path($gift->image));
            }
            $gift->image = $image;
        }
        $gift->title = $request->get('title');
        $gift->code = $request->get('code');
        $gift->quantity = $request->get('quantity');
        $gift->percent = $request->get('percent') / 100;
        $gift->rule_rotation_id = $request->get('rule_rotation_id');
        $gift->save();
        return back()->with(['success' => 'Cập nhật quà tặng thành công']);
    }

    public function deleteGift ($id){
        $gift = GiftRotation::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        if (file_exists(public_path($gift->image))) {
            unlink(public_path($gift->image));
        }
        $gift->delete();
        return back()->with(['error' => 'Xóa dữ liệu thành công']);
    }

    /**
     * Giao diện vòng quay cho khách hàng
    **/
    public function playRotation (Request $request)
    {
        return view('rotation');
    }
    /**
     * Lích sử khách hàng chúng quà
    **/
    public function historyExchangeGift (Request $request)
    {
        $listData = HistoryGiftRotation::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('name_customer', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('phone_customer', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('name_gift', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code_gift', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->rule_rotation_id)){
            $listID = HistoryInvoiceRotation::where('rule_rotation_id', $request->get('rule_rotation_id'))->where('used', 1)->pluck('id')->toArray();
            $listData = $listData->whereIn('history_invoice_rotation_id', $listID);
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        $rule_rotation = RuleRotation::all();
        return view('rotation.history_gift', compact('listData', 'rule_rotation'));
    }
    /**
     * API vòng quay may mắn
    **/
    public function listGiftAPI (Request $request)
    {
        $token = $this->kiotVietService->getAccessToken();
        $rotation = RotationModel::first();
        $ruleDefaultID = RuleRotation::first()->id??0;
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            $dataCustomer = $this->infoCustomer($request->get('phone'), $token);
            if (!empty($dataCustomer) && !empty($dataCustomer['data'])){
                foreach ($dataCustomer['data'] as $infoCustomer){
                    $customer = new Customer([
                        'kiotviet_id' => $infoCustomer['id'],
                        'code'           => $infoCustomer['code'] ?? null,
                        'name'           => $infoCustomer['name'],
                        'contact_number' => $infoCustomer['contactNumber'] ?? null,
                        'address'        => $infoCustomer['address'] ?? null,
                        'retailer_id'    => $infoCustomer['retailerId'],
                        'branch_id'      => $infoCustomer['branchId'],
                        'location_name'  => $infoCustomer['locationName'] ?? null,
                        'ward_name'      => $infoCustomer['wardName'] ?? null,
                        'modified_date'  => $infoCustomer['modifiedDate'] ?? null,
                        'created_date'   => $infoCustomer['createdDate'] ?? null,
                        'type'           => $infoCustomer['type'] ?? 0,
                        'organization'   => $infoCustomer['organization'] ?? null,
                        'comments'       => $infoCustomer['comments'] ?? null,
                        'debt'           => $infoCustomer['debt'] ?? 0,
                        'total_invoiced' => $infoCustomer['totalInvoiced'] ?? 0,
                        'total_revenue'  => $infoCustomer['totalRevenue'] ?? 0,
                        'total_point'    => $infoCustomer['totalPoint'] ?? 0,
                        'kiotviet_reward_point' => $infoCustomer['rewardPoint'],
                        'used_points'    => 0,
                        'reward_point'   => $infoCustomer['rewardPoint'],
                    ]);
                    $customer->save();
                }
            }else{
                $listGift = GiftRotation::where('rule_rotation_id', $ruleDefaultID)->get();
                $countPlay = 0;
                $dateReturn = [
                    'status' => true,
                    'data' => $listGift,
                    'number_play' => $countPlay
                ];
                return response()->json($dateReturn, Response::HTTP_OK);
            }
        }
        $this->getInvoiceKiotviet($rotation, $customer, $token);
        $ruleID = HistoryInvoiceRotation::where('customer_id', $customer->id)->where('used', 0)->first()->rule_rotation_id??0;
        $countPlay = HistoryInvoiceRotation::where('customer_id', $customer->id)->where('used', 0)->count();
        if ($ruleID > 0){
            $listGift = GiftRotation::where('rule_rotation_id', $ruleID)->get();
        }else{
            $listGift = GiftRotation::where('rule_rotation_id', $ruleDefaultID)->get();
        }
        $dateReturn = [
            'status' => true,
            'data' => $listGift,
            'number_play' => $countPlay
        ];
        return response()->json($dateReturn, Response::HTTP_OK);
    }

    /**
     * Lấy đơn hàng và cộng lượt quay cho khach hàng
    **/
    public function getInvoiceKiotviet ($rotation, $customer, $token){
        $endpoint = 'https://public.kiotapi.com/invoices?fromPurchaseDate='.$rotation->time_start.'&toPurchaseDate='.$rotation->time_end.'&customerIds='.$customer->kiotviet_id.'&pageSize=100';
        $response = Http::withHeaders([
            'Retailer' => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint);
        $listInvoice = $response->json();
        if (!empty($listInvoice) && !empty($listInvoice['data'])){
            foreach ($listInvoice['data'] as $dataInvoice){
                $check = HistoryInvoiceRotation::where('invoice_code', $dataInvoice['code'])->exists();
                if (!$check){
                    $maxRuleMoney = RuleRotation::max('money_invoice_2');
                    if ($dataInvoice['total'] > $maxRuleMoney){
                        $rule = RuleRotation::where('money_invoice_2', $maxRuleMoney)->first();
                    }else{
                        $rule = RuleRotation::where('money_invoice_1', '<=', $dataInvoice['total'])->where('money_invoice_2', '>=', $dataInvoice['total'])->first();
                    }
                    if (isset($rule)){
                        $historyInvoiceRule = new HistoryInvoiceRotation([
                            'invoice_code' => $dataInvoice['code'],
                            'customer_id' => $customer->id,
                            'rule_rotation_id' => $rule->id,
                            'branch_id' => $dataInvoice['branchId'],
                            'money_invoice' => $dataInvoice['total'],
                            'used' => 0
                        ]);
                        $historyInvoiceRule->save();
                    }
                }
            }
        }
        return true;
    }
    /**
     * Đổi quà tặng
    **/
    public function exchangeGiftAPI (Request $request)
    {
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Thông tin số điện thoại khách hàng không chính xác. Vui lòng kiểm tra lại'], Response::HTTP_OK);
        }
        $gift = GiftRotation::where('id', $request->get('gift_id'))->lockForUpdate()->first();
        if (empty($gift)){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm không tồn tại.Vui lòng thử lại sau'], Response::HTTP_OK);
        }
        if ($gift->quantity < 1){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm đã hết. Xin vui lòng quay thêm lần nữa để nhận quà khác'], Response::HTTP_OK);
        }
        $gift->quantity = $gift->quantity - 1;
        $gift->save();
        $historyInvoice = HistoryInvoiceRotation::where('customer_id', $customer->id)->where('used', 0)->first();
        $historyInvoice->used = 1;
        $historyInvoice->save();
        $historyGift = new HistoryGiftRotation([
            'customer_id' => $customer->id,
            'name_customer' => $customer->name,
            'phone_customer' => $customer->contact_number,
            'history_invoice_rotation_id' => $historyInvoice->id,
            'name_gift' => $gift->title,
            'image_gift' => $gift->image,
            'code_gift' => $gift->code,
            'status' => 1
        ]);
        $historyGift->save();
        return \response()->json(['status' => true, 'msg' => 'Chúc mừng bạn đã nhận được phần quà: '.$gift->title], Response::HTTP_OK);
    }
    /**
     * Xem danh sách quà của tôi
    **/
    public function getMyGiftAPI (Request $request)
    {
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Thông tin số điện thoại khách hàng không chính xác. Vui lòng kiểm tra lại'], Response::HTTP_OK);
        }
        $listMyGift = HistoryGiftRotation::where('customer_id',$customer->id)->orderBy('created_at', 'desc')->get();
        return \response()->json(['status' => true, 'data' => $listMyGift], Response::HTTP_OK);
    }
    /**
     * Lấy thông tin khách hàng kiotviet = số điện thoại
    **/
    public function infoCustomer ($phone, $accessToken)
    {
        if (empty($phone)){
            return [];
        }
        $response = Http::withHeaders([
            'Retailer'      => $this->kiotVietService->getRetailer(),
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get("https://public.kiotapi.com/customers?orderDirection=Desc&includeTotal=true&contactNumber=$phone");

        $data = $response->json();
        return $data;
    }
}
