<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\HelperAdminController;
use App\Models\Customer;
use App\Models\GiftRotation;
use App\Models\HistoryGiftRotation;
use App\Models\HistoryInvoiceRotation;
use App\Models\Invoice;
use App\Models\RotationModel;
use App\Models\RuleRotation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Http\Controllers\API\HelperApiController;

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
    public function listGiftAPI (Request $request, HelperApiController $helperApiController)
    {
        try {
            // Validate số điện thoại
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $phone = $helperApiController->normalizePhone($validatedData['phone']);

            $rotation = RotationModel::first();
            $ruleDefaultID = RuleRotation::first()->id??0;
            $customer = Customer::where('contact_number', $phone)->first();
            if (empty($customer)){
                $listGift = GiftRotation::where('rule_rotation_id', $ruleDefaultID)->get();
                $countPlay = 0;
                $dateReturn = [
                    'status' => true,
                    'data' => $listGift,
                    'number_play' => $countPlay
                ];
                return response()->json($dateReturn, Response::HTTP_OK);
            }
            $this->getInvoiceKiotviet($rotation, $customer);
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
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 200);
        }
    }

    /**
     * Lấy đơn hàng và cộng lượt quay cho khach hàng
    **/
    public function getInvoiceKiotviet($rotation, $customer)
    {
        // Lấy danh sách invoice theo số điện thoại và khoảng thời gian
        $listInvoice = Invoice::where('contact_number', $customer->contact_number)
            ->whereBetween('created_date', [$rotation->time_start, $rotation->time_end])
            ->get();

        // Lấy các mã hóa đơn đã được ghi nhận trước đó để tránh duplicate
        $existingInvoiceCodes = HistoryInvoiceRotation::whereIn('invoice_code', $listInvoice->pluck('code'))->pluck('invoice_code')->toArray();

        // Lấy tất cả rule, sắp xếp theo money_invoice_1 tăng dần
        $rules = RuleRotation::select('id', 'money_invoice_1', 'money_invoice_2')->orderBy('money_invoice_1', 'asc')->get();

        foreach ($listInvoice as $invoice) {
            if (in_array($invoice->code, $existingInvoiceCodes)) {
                continue; // Đã xử lý => bỏ qua
            }

            // Tìm rule phù hợp với tổng tiền
            $rule = $rules->first(function ($r) use ($invoice) {
                return $invoice->total >= $r->money_invoice_1 && $invoice->total <= $r->money_invoice_2;
            });

            // Nếu không tìm thấy rule phù hợp, dùng rule có money_invoice_2 lớn nhất
            if (!$rule) {
                $rule = $rules->sortByDesc('money_invoice_2')->first();
            }

            if ($rule) {
                HistoryInvoiceRotation::create([
                    'invoice_code' => $invoice->code,
                    'customer_id' => $customer->id,
                    'rule_rotation_id' => $rule->id,
                    'branch_id' => $invoice->branch_id,
                    'money_invoice' => $invoice->total,
                    'used' => 0
                ]);
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
}
