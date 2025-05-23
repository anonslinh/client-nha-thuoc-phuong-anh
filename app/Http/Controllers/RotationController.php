<?php

namespace App\Http\Controllers;

use App\Exports\HistoryCustomerExchangeGift;
use App\Exports\RotationExchangeGiftCheckinExport;
use App\Http\Controllers\Admin\HelperAdminController;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerGiftCheckin;
use App\Models\GiftCheckin;
use App\Models\GiftRotation;
use App\Models\GiftRotationQuantity;
use App\Models\GiftRotationSub;
use App\Models\HistoryGiftRotation;
use App\Models\HistoryInvoiceRotation;
use App\Models\Invoice;
use App\Models\QuantityGiftCheckin;
use App\Models\RotationCheckin;
use App\Models\RotationModel;
use App\Models\RuleRotation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Controllers\API\HelperApiController;
use App\Models\InterfaceRotation;
use Maatwebsite\Excel\Facades\Excel;

class RotationController extends HelperAdminController
{
    public function setting (Request $request)
    {
        $rotation = RotationModel::first();
        $dataRule = [];
        if (!empty($rotation)){
           $dataRule = $rotation->DataRuleRotation;
        }
        $interface_rotation = InterfaceRotation::first();
        return view('rotation.index', compact('rotation', 'dataRule', 'interface_rotation'));
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
        foreach ($listData as $value){
            $value['quantity'] = GiftRotationQuantity::where('gift_rotation_id', $value->id)->sum('quantity')??0;
        }
        $rule_rotation = RuleRotation::all();
        return view('rotation.gift', compact('listData', 'rule_rotation'));
    }
    public function addGift (Request $request)
    {
        $listBranch = Branch::all();
        $rule_rotation = RuleRotation::all();
        return view('rotation.create_gift', compact('listBranch', 'rule_rotation'));
    }
    public function createGift (Request $request)
    {
        try{
            $checkQuantity = false;
            if (empty($request->get('branch'))){
                return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
            }
            foreach ($request->get('branch') as $value){
                if (isset($value['quantity']) && $value['quantity'] >= 1){
                    $checkQuantity = true;
                }
            }
            if (!$checkQuantity){
                return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
            }
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
                'quantity' => 0,
                'percent' => $request->get('percent') / 100,
                'rule_rotation_id' => $request->get('rule_rotation_id'),
                'image' => $image
            ]);
            $gift->save();
            foreach ($request->get('branch') as $value){
                if (isset($value['quantity'])){
                    $giftQuantity = new GiftRotationQuantity([
                        'gift_rotation_id' => $gift['id'],
                        'branches_id' => $value['id'],
                        'quantity' => $value['quantity']
                    ]);
                    $giftQuantity->save();
                }
            }
            return back()->with(['success' => 'Cấu hình quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại']);
        }
    }
    public function detailGift ($id)
    {
        $gift = GiftRotation::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $listBranch = Branch::all();
        foreach ($listBranch as $value){
            $value->quantity_gift = GiftRotationQuantity::where('branches_id', $value->id)->where('gift_rotation_id', $id)->first()->quantity??null;
        }
        $rule_rotation = RuleRotation::all();
        return view('rotation.detail_gift', compact('listBranch', 'rule_rotation', 'gift'));
    }
    public function updateGift (Request $request, $id)
    {
        $gift = GiftRotation::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $checkQuantity = false;
        if (empty($request->get('branch'))){
            return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
        }
        foreach ($request->get('branch') as $value){
            if (isset($value['quantity']) && $value['quantity'] > 1){
                $checkQuantity = true;
            }
        }
        if (!$checkQuantity){
            return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
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
        $gift->percent = $request->get('percent') / 100;
        $gift->rule_rotation_id = $request->get('rule_rotation_id');
        $gift->save();
        GiftRotationQuantity::where('gift_rotation_id', $id)->delete();
        foreach ($request->get('branch') as $value){
            if (isset($value['quantity'])){
                $giftQuantity = new GiftRotationQuantity([
                    'gift_rotation_id' => $gift['id'],
                    'branches_id' => $value['id'],
                    'quantity' => $value['quantity']
                ]);
                $giftQuantity->save();
            }
        }
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
        foreach ($listData as $value){
            $invoiceRotation = HistoryInvoiceRotation::find($value->history_invoice_rotation_id);
            $branch = Branch::where('kiotviet_id', $invoiceRotation->branch_id)->first();
            $value['invoice_code'] = $invoiceRotation->invoice_code;
            $value['branch_name'] = $branch->branch_name??'';
        }
        $totalGift = $listData->total();
        $rule_rotation = RuleRotation::all();
        return view('rotation.history_gift', compact('listData', 'rule_rotation', 'totalGift'));
    }
    /**
     * Xuất excel
    **/
    public function exportHistoryExchangeGift ()
    {
        return Excel::download(new HistoryCustomerExchangeGift(), 'Danh_sach_khach_hang_chung_qua.xlsx');
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
            if (empty($customer) || empty($rotation)){
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
            if (in_array($invoice->code, $existingInvoiceCodes) || $invoice->total_payment == 0) {
                continue; // Đã xử lý => bỏ qua
            }

            // Tìm rule phù hợp với tổng tiền
            $rule = $rules->first(function ($r) use ($invoice) {
                return $invoice->total >= $r->money_invoice_1 && $invoice->total <= $r->money_invoice_2;
            });

            // Nếu không tìm thấy rule phù hợp và total > max(money_invoice_2), gán rule cuối cùng
            if (!$rule) {
                $maxMoney = $rules->max('money_invoice_2');
                if ($invoice->total > $maxMoney) {
                    $rule = $rules->where('money_invoice_2', $maxMoney)->first();
                }
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
        $gift = GiftRotation::where('id', $request->get('gift_id'))->first();
        if (empty($gift)){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm không tồn tại.Vui lòng thử lại sau'], Response::HTTP_OK);
        }
        $historyInvoice = HistoryInvoiceRotation::where('customer_id', $customer->id)->where('used', 0)->first();
        $branchKiotVietID = $historyInvoice->branch_id??0;
        $branch = Branch::where('kiotviet_id', $branchKiotVietID)->first();
        $branchID = $branch->id??0;
        $quantity = GiftRotationQuantity::where('gift_rotation_id', $gift->id)->where('branches_id', $branchID)->lockForUpdate()->first();
        if (empty($quantity) || $quantity->quantity < 1){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm đã hết. Xin vui lòng quay thêm lần nữa để nhận quà khác'], Response::HTTP_OK);
        }
        $quantity->quantity -= 1;
        $quantity->save();
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
     * Quà tặng ở cửa hàng cô Xuyến
    **/
    public function subGift (Request $request)
    {
        $listData = GiftRotationSub::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        if (isset($request->rule_rotation_id)){
            $listData = $listData->where('rule_rotation_id', $request->get('rule_rotation_id'));
        }
        $listData = $listData->paginate(20);
        $rule_rotation = RuleRotation::all();
        return view('rotation.gift_2', compact('listData', 'rule_rotation'));
    }

    public function createGift2 (Request $request)
    {
        try{
            if (!$request->hasFile('image')){
                return back()->with(['error' => 'Vui lòng thêm hình ảnh quà tặng']);
            }
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            $gift = new GiftRotationSub([
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

    public function deleteGiftSub ($id)
    {
        $gift = GiftRotationSub::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        if (file_exists(public_path($gift->image))) {
            unlink(public_path($gift->image));
        }
        $gift->delete();
        return back()->with(['error' => 'Xóa dữ liệu thành công']);
    }

    public function updateGift2 (Request $request, $id)
    {
        $gift = GiftRotationSub::find($id);
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
        $gift->percent = $request->get('percent') / 100;
        $gift->quantity = $request->get('quantity');
        $gift->rule_rotation_id = $request->get('rule_rotation_id');
        $gift->save();
        return back()->with(['success' => 'Cập nhật quà tặng thành công']);
    }

    /**
     * API lấy danh sách quà tặng theo giá trị hóa đơn
    **/
    public function listGiftSubAPI (Request $request)
    {
        $money = $request->get('money');
        if (isset($money) && is_numeric($money)){
            $maxMoney = RuleRotation::max('money_invoice_2');
            if ($maxMoney <= $money){
                $ruleID = RuleRotation::where('money_invoice_2', $maxMoney)->first()->id??0;
            }else{
                $ruleID = RuleRotation::where('money_invoice_1', '<=', $money)->where('money_invoice_2', '>=', $money)->first()->id ?? 0;
            }
            $listGift = GiftRotationSub::where('rule_rotation_id', $ruleID)->get();
        }else{
            $listGift = [];
        }
        $dateReturn = [
            'status' => true,
            'data' => $listGift,
            'number_play' => 1
        ];
        return response()->json($dateReturn, Response::HTTP_OK);
    }

    public function exchangeGiftSubAPI (Request $request)
    {
        $gift = GiftRotationSub::where('id', $request->get('gift_id'))->first();
        if (empty($gift)){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm không tồn tại.Vui lòng thử lại sau'], Response::HTTP_OK);
        }
        if ($gift->quantity < 1){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng sản phẩm đã hết. Xin vui lòng quay thêm lần nữa để nhận quà khác'], Response::HTTP_OK);
        }
        $gift->quantity -= 1;
        $gift->save();
        return \response()->json(['status' => true, 'msg' => 'Chúc mừng bạn đã nhận được phần quà: '.$gift->title], Response::HTTP_OK);
    }
    /**
     * Vòng quay checkin
    **/
    public function listGiftCheckin (Request $request)
    {
        $listData = GiftCheckin::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        $listData = $listData->paginate(20);
        foreach ($listData as $value){
            $value['quantity'] = QuantityGiftCheckin::where('gift_checkin_id', $value->id)->sum('quantity')??0;
        }
        return view('rotation.gift_checkin', compact('listData'));
    }

    public function createGiftCheckin ()
    {
        $listBranch = Branch::all();
        return view('rotation.create_gift_checkin', compact('listBranch'));
    }

    public function storedGiftCheckin (Request $request)
    {
        try{
            $checkQuantity = false;
            if (empty($request->get('branch'))){
                return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
            }
            foreach ($request->get('branch') as $value){
                if (isset($value['quantity']) && $value['quantity'] > 1){
                    $checkQuantity = true;
                }
            }
            if (!$checkQuantity){
                return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
            }
            if (!$request->hasFile('image')){
                return back()->with(['error' => 'Vui lòng thêm hình ảnh quà tặng']);
            }
            $file = $request->file('image');
            $nameFile = 'gift-checkin'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            $gift = new GiftCheckin([
                'title' => $request->get('title'),
                'code' => $request->get('code'),
                'percent' => $request->get('percent') / 100,
                'image' => $image
            ]);
            $gift->save();
            foreach ($request->get('branch') as $value){
                if (isset($value['quantity'])){
                    $giftQuantity = new QuantityGiftCheckin([
                        'gift_checkin_id' => $gift['id'],
                        'branch_id' => $value['id'],
                        'quantity' => $value['quantity']
                    ]);
                    $giftQuantity->save();
                }
            }
            return back()->with(['success' => 'Cấu hình quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Vui lòng điền đầy đủ thông tin']);
        }
    }
    public function deleteGiftCheckin ($id)
    {
        $gift = GiftCheckin::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $gift->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }

    public function detailGiftCheckin($id)
    {
        $gift = GiftCheckin::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $listBranch = Branch::all();
        foreach ($listBranch as $value){
            $value->quantity_gift = QuantityGiftCheckin::where('branch_id', $value->id)->where('gift_checkin_id', $id)->first()->quantity??null;
        }
        return view('rotation.detail_gift_checkin', compact('listBranch', 'gift'));
    }

    public function updateGiftCheckin (Request $request, $id)
    {
        $gift = GiftCheckin::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $checkQuantity = false;
        if (empty($request->get('branch'))){
            return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
        }
        foreach ($request->get('branch') as $value){
            if (isset($value['quantity']) && $value['quantity'] > 1){
                $checkQuantity = true;
            }
        }
        if (!$checkQuantity){
            return back()->with(['error' => 'Vui lòng thêm số lượng quà tặng cho các chi nhánh']);
        }

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = 'gift-checkin'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            if (file_exists(public_path($gift->image))) {
                unlink(public_path($gift->image));
            }
            $gift->image = $image;
        }
        $gift->title = $request->get('title');
        $gift->code = $request->get('code');
        $gift->percent = $request->get('percent') / 100;
        $gift->save();
        QuantityGiftCheckin::where('gift_checkin_id', $id)->delete();
        foreach ($request->get('branch') as $value){
            if (isset($value['quantity'])){
                $giftQuantity = new QuantityGiftCheckin([
                    'gift_checkin_id' => $gift['id'],
                    'branch_id' => $value['id'],
                    'quantity' => $value['quantity']
                ]);
                $giftQuantity->save();
            }
        }
        return back()->with(['success' => 'Cập nhật quà tặng thành công']);
    }

    public function exchangeGiftCheckin (Request $request)
    {
        $listData = CustomerGiftCheckin::query();
        if (isset($request->key_search)){
            $listData = $listData->where('phone', 'like', '%'.$request->get('key_search').'%');
        }
        if (isset($request->branch_id)){
            $listData = $listData->where('branch_id', $request->get('branch_id'));
        }
        $listData = $listData->orderBy('created_at','desc')->paginate(20);
        $branch = Branch::all();
        return view('rotation.history_gift_checkin', compact('listData', 'branch'));
    }
    /**
     * Đăng ký và lấy danh sách quà vòng quay checkin
    **/
    public function listGiftCheckinAPI (Request $request)
    {
        $rule = [
            'phone' => [
                'required',
                'regex:/^(0|\+84)[3-9][0-9]{8}$/'
            ],
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            'branch_id' => [
                'required',
                'exists:branches,id'
            ]
        ];

        $message = [
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'image.required' => 'Vui lòng chọn ảnh',
            'image.image' => 'Tệp tải lên phải là hình ảnh',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, hoặc svg',
            'image.max' => 'Kích thước ảnh tối đa là 2MB',
            'branch_id.required' => 'Vui lòng chọn chi nhánh',
            'branch_id.exists' => 'Chi nhánh không tồn tại',
        ];
        $validation = Validator::make($request->all(), $rule, $message);
        if ($validation->fails()){
            return \response()->json(['status' => false, 'msg' => $validation->errors()->first()], 200);
        }
        $rotation = RotationCheckin::where('phone', $request->get('phone'))->first();
        $file = $request->file('image');
        if (empty($rotation)){
            $nameFile = 'customer-checkin'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            $rotation = new RotationCheckin([
                'phone' => $request->get('phone'),
                'branch_id' => $request->get('branch_id'),
                'image' => $image
            ]);
            $rotation->save();
        }else{
            if ($rotation->use == 1){
                return \response()->json(['status' => false, 'msg' => 'Mỗi người chỉ được đăng ký một lần và một lượt quay. Trân trọng cảm ơn'], 200);
            }
            $nameFile = 'customer-checkin'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-rotation/', $nameFile);
            $image = 'upload/gift-rotation/'.$nameFile;
            $rotation->image = $image;
            $rotation->save();
        }
        $listGift = GiftCheckin::all();
        return \response()->json(['status' => true, 'data' => $listGift], 200);
    }
    /**
     * Đổi quà vòng quay checkin
    **/
    public function exchangeGiftCheckinAPI (Request $request)
    {
        $gift = GiftCheckin::find($request->get('gift_id'));
        if (empty($gift)){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng không tồn tại'], 200);
        }
        $customer = RotationCheckin::where('phone', $request->get('phone'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Bạn chưa đăng ký vòng quay.Vui lòng đăng ký vòng quay']);
        }
        if ($customer->use == 1){
            return \response()->json(['status' => false, 'msg' => 'Mỗi người chỉ được đăng ký một lần và một lượt quay. Trân trọng cảm ơn'], 200);
        }
        $branch = Branch::find($request->get('branch_id'));
        if (empty($branch)){
            return \response()->json(['status' => false, 'msg' => 'Vui lòng chọn lại chi nhánh để tiếp tục'], 200);
        }
        $quantity = QuantityGiftCheckin::where('gift_checkin_id', $gift->id)->where('branch_id', $request->get('branch_id'))->first()->quantity ?? 0;
        if ($quantity == 0){
            return \response()->json(['status' => false, 'msg' => 'Phần quà ở chi nhánh hiện tại đã hết.Vui lòng quay để nhận quà khách'], 200);
        }
        $customer_gift_checkin = new CustomerGiftCheckin([
            'phone' => $customer->phone,
            'gift_name' => $gift->title,
            'gift_code' => $gift->code,
            'gift_image' => $gift->image,
            'branch_name' => $branch->branch_name,
            'branch_id' => $branch->id
        ]);
        $customer_gift_checkin->save();
        $customer->use = 1;
        $customer->save();
        return \response()->json(['status' => true, 'msg' => 'Chúc mừng bạn đã nhận được phần quà: '.$gift->title], 200);
    }
    /**
     * Xuất excel
    **/
    public function exportExchangeGiftCheckin (Request $request)
    {
        return Excel::download(new RotationExchangeGiftCheckinExport($request), 'Lich-su-doi-qua-vong-quay-checkin.xlsx');
    }

    /**
     * Giao diện vòng quay
    **/
    public function interface(Request $request){
        $logo = null;
        if($request->hasFile('logo')){
            $file = $request->file('logo');
            $nameFile = 'logo'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/rotation/', $nameFile);
            $logo = 'upload/rotation/'.$nameFile;
        }
        $background = null;
        if($request->hasFile('background')){
            $file = $request->file('background');
            $nameFile = 'background'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/rotation/', $nameFile);
            $background = 'upload/rotation/'.$nameFile;
        }
        $rotationImage = null;
        if($request->hasFile('rotation')){
            $file = $request->file('rotation');
            $nameFile = 'rotation'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/rotation/', $nameFile);
            $rotationImage = 'upload/rotation/'.$nameFile;
        }
        $interface = InterfaceRotation::first();
        if(isset($interface)){
            $interface->logo = $logo??$interface->logo;
            $interface->background = $background??$interface->background;
            $interface->rotation = $rotationImage??$interface->rotation;
            $interface->color_button = $request->get('color_button')??$interface->color_button;
            $interface->color_gift = $request->get('color_gift')??$interface->color_gift;
        }else{
            $interface = new InterfaceRotation([
                'logo' => $logo,
                'background' => $background,
                'rotation' => $rotationImage,
                'color_button' => $request->get('color_button'),
                'color_gift' => $request->get('color_gift')
            ]);
        }
        $interface->save();
        return back()->with(['success' => 'Cập nhập giao diện vòng quay thành công']);
    }

    public function interfaceAPI ()
    {
        $interface = InterfaceRotation::first();
        return response()->json(['status' => true, 'data' => $interface], 200);
    }
}
