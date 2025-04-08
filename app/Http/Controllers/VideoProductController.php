<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\API\HelperApiController;
use App\Models\Branch;
use App\Models\CartModel;
use App\Models\Customer;
use App\Models\ExchangeGiftEvent;
use App\Models\Gift;
use App\Models\GiftEvent;
use App\Models\HistoryPointEvent;
use App\Models\Invoice;
use App\Models\ProductsModel;
use App\Models\QuantityGiftEvents;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class VideoProductController extends SyncController
{
    public function video (Request $request)
    {
        $listData = VideoYoutube::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('title', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('id_video', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('index','asc')->paginate(20);
        return view('product.video', compact('listData'));
    }

    public function store (Request $request)
    {
        $maxIndex = VideoYoutube::max('index');
        $maxIndex = $maxIndex + 1;
        $index = $request->get('index')??$maxIndex;
        $active = 0;
        if ($request->get('status') == 'active'){
            $active = 1;
        }
        $video = new VideoYoutube([
            'title' => $request->get('title'),
            'id_video' => $request->get('id_video'),
            'index' => $index,
            'is_active' => $active
        ]);
        $video->save();
        return back()->with(['success' => 'Thêm video sản phẩm thành công']);
    }

    public function delete ($id)
    {
        $video = VideoYoutube::find($id);
        if (empty($video)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $video->delete();
        return back()->with(['success' => 'Xóa video thành công']);
    }
    public function update (Request $request, $id)
    {
        $video = VideoYoutube::find($id);
        if (empty($video)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $maxIndex = VideoYoutube::max('index');
        $maxIndex = $maxIndex + 1;
        $index = $request->get('index')??$maxIndex;
        $active = 0;
        if ($request->get('status') == 'active'){
            $active = 1;
        }
        $video->title = $request->get('title')??$video->title;
        $video->id_video = $request->get('id_video')??$video->id_video;
        $video->index = $index;
        $video->is_active = $active;
        $video->save();
        return back()->with(['success' => 'Cập nhật video thành công']);
    }
    /**
     * API lấy id video
    **/
    public function idVideoApi (Request $request)
    {
        $listVideo = VideoYoutube::where('is_active', 1)->orderBy('index', 'asc')->paginate(5);
        return response()->json(['status' => true, 'data' => $listVideo], Response::HTTP_OK);
    }
    /**
     * Cài đặt sản phẩm mua là có quà
    **/
    public function giftProduct (Request $request)
    {
        $listProduct = ProductsModel::query();
        if (isset($request->key_search)){
            $listProduct = $listProduct->where(function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code','like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->point)){
            $listProduct = $listProduct->where('point', $request->get('point'));
        }
        $listProduct = $listProduct->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listProduct as $value){
            $value['image'] = json_decode($value->image);
        }
        $point = Gift::orderBy('points_required', 'asc')->pluck('points_required')->toArray();
        $point = array_unique($point);
        return view('product.index', compact('listProduct', 'point'));
    }
    /**
     * Tạo sản phẩm
    **/
    public function createProduct (Request $request)
    {
        $point = GiftEvent::orderBy('point', 'asc')->pluck('point')->toArray();
        $point = array_unique($point);
        return view('product.create', compact( 'point'));
    }
    public function storeProduct (Request $request)
    {
        try{
            if (!$request->hasFile('image')){
                return back()->with(['error' => 'Vui lòng thêm hình ảnh sản phẩm']);
            }
            $image = [];
            foreach ($request->file('image') as $file){
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/product/', $fileName);
                $image[] = 'upload/product/'.$fileName;
            }
            $product = new ProductsModel([
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'trademark' => $request->get('trademark'),
                'price' => $request->get('price')??0,
                'point' => $request->get('point'),
                'description' => $request->get('description'),
                'image' => json_encode($image)
            ]);
            $product->save();
            return back()->with(['success' => 'Tạo sản phẩm thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => $exception->getMessage()]);
        }
    }
    /**
     * Chi tiết quà tặng
    **/
    public function detailProduct ($id)
    {
        $product = ProductsModel::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $product['image'] = json_decode($product->image);
        $point = GiftEvent::orderBy('point', 'asc')->pluck('point')->toArray();
        $point = array_unique($point);
        return view('product.detail', compact( 'point', 'product'));
    }
    /**
     * Cập nhật quà tặng
    **/
    public function updateProduct (Request $request, $id)
    {
        $product = ProductsModel::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $imageProduct = $request->get('image_product')??[];
        if ($request->hasFile('image')){
            foreach ($request->file('image') as $file){
                $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/product/', $fileName);
                $imageProduct[] = 'upload/product/'.$fileName;
            }
        }
        if (empty($imageProduct)){
            return back()->with(['error' => 'Không để trống hình ảnh sản phẩm']);
        }
        $product->name = $request->get('name');
        $product->code = $request->get('code');
        $product->trademark = $request->get('trademark');
        $product->price = $request->get('price');
        $product->point = $request->get('point');
        $product->description = $request->get('description');
        $product->image = json_encode($imageProduct);
        $product->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Danh sách quà tặng theo sản phẩm
    **/
    public function listGift (Request $request, $id)
    {
        $product = ProductsModel::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $listData = GiftEvent::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->where('point', $product->point)->paginate(20);
        return view('product.list_gift', compact('listData', 'product'));
    }
    /**
     * Xóa sản phẩm
    **/
    public function deleteProduct ($id)
    {
        $product = ProductsModel::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $images = json_decode($product->image);
        foreach ($images as $image){
            if (file_exists(public_path($image))) {
                unlink(public_path($image));
            }
        }
        $product->delete();
        return back()->with(['success' => 'Xóa sản phẩm thành công']);
    }

    /**
     * API mua là có quà
    **/
    /**
     * Danh sách sản phẩm ngoài trang chủ
    **/
    public function homeAPI (){
        $listProduct = ProductsModel::where('is_active', 1)->inrandomOrder()->limit(20)->get();
        foreach ($listProduct as $value){
            $value['image'] = json_decode($value->image);
            $listGift = GiftEvent::where('point', $value->point)->where('active', 1)->get();
            $value['list_gift'] = $listGift;
        }
        return \response()->json(['status' => true, 'data' => $listProduct], Response::HTTP_OK);
    }
    /**
     * Lấy danh mục winxu
    **/
    public function categoryPoint ()
    {
        $points = GiftEvent::orderBy("point", 'asc')->pluck('point')->toArray();
        $points = array_unique($points);
        $dataReturn = [];
        foreach ($points as $point){
            $item = [];
            $item['point'] = $point;
            $item['name'] = $point. ' Winxu';
            $dataReturn[] = $item;
        }
        return \response()->json(['status' => true, 'data' => $dataReturn], Response::HTTP_OK);
    }
    /**
     * Danh sách sản phẩm
    **/
    public function listProduct (Request $request)
    {
        $listProduct = ProductsModel::query();
        if (isset($request->point)){
            $listProduct = $listProduct->where('point', $request->get('point'));
        }
        $listProduct = $listProduct->where('is_active', 1)->paginate(20);
        foreach ($listProduct as $value){
            $value['image'] = json_decode($value->image);
            $listGift = GiftEvent::where('point', $value->point)->where('active', 1)->get();
            $value['list_gift'] = $listGift;
        }
        return \response()->json(['status' => true, 'data' => $listProduct], Response::HTTP_OK);
    }
    /**
     * Chi tiết sản phẩm API
    **/
    public function detailProductAPI (Request $request)
    {
        $product = ProductsModel::find($request->get('product_id'));
        if (empty($product)){
            return \response()->json(['status' => false, 'msg' => 'Sản phẩm không tồn tại'], Response::HTTP_BAD_REQUEST);
        }
        $listGift = GiftEvent::where('point', $product->point)->where('active', 1)->limit(10)->get();
        $similarProducts = ProductsModel::whereNot('id', $request->get('product_id'))->where('point', $product->point)->limit(10)->get();
        foreach ($similarProducts as $value){
            $value['image'] = json_decode($value->image);
        }
        $product['image'] = json_decode($product->image);
        return \response()->json(['status' => true, 'data' => [
            'product' => $product,
            'list_gift' => $listGift,
            'similar_products' => $similarProducts
        ]], Response::HTTP_OK);
    }
    /**
     * Danh sách quà tặng
    **/
    public function listGiftAPI (Request $request)
    {
        $listGift = GiftEvent::query();
        if (isset($request->point)){
            $listGift = $listGift->where('point', $request->get('point'));
        }
        $listGift = $listGift->where('active', 1)->paginate(20);
        return \response()->json(['status' => true, 'data' => $listGift], Response::HTTP_OK);
    }
    /**
     * Chi tiết quà tặng
    **/
    public function detailGift (Request $request)
    {
        $gift = GiftEvent::find($request->get('gift_id'));
        if (empty($gift)){
            return \response()->json(['status' => false, 'msg' => 'Quà tặng không tồn tại'], Response::HTTP_BAD_REQUEST);
        }
        $listProduct = ProductsModel::where('point', $gift->point)->where('is_active', 1)->limit(10)->get();
        foreach ($listProduct as $value){
            $value['image'] = json_decode($value->image);
        }
        return \response()->json(['status' => true, 'data' => [
            'gift' => $gift,
            'list_product' => $listProduct
        ]], Response::HTTP_OK);
    }
    /**
     * Lấy thông tin người dùng winxu
    **/
    public function infoCustomer(Request $request, HelperApiController $helperApiController)
    {
        try{
            // 1. Validate input
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            // 2. Chuẩn hoá số điện thoại
            $phone = $helperApiController->normalizePhone($validatedData['phone']);

            // 3. Lấy thông tin khách hàng
            $customer = Customer::where('contact_number', $phone)->first();

            if (!$customer) {
                return response()->json(['status' => true, 'data' => 0], Response::HTTP_OK);
            }

            // 4. Lấy sản phẩm có ngày tạo nhỏ nhất
            $earliestProduct = ProductsModel::orderBy('created_at', 'asc')->first();

            if ($earliestProduct) {
                // 5. Lấy danh sách hoá đơn cần xử lý (có ngày >= ngày tạo sản phẩm đầu tiên)
                $invoices = Invoice::where('contact_number', $phone)
                    ->where('created_date', '>=', $earliestProduct->created_at)
                    ->with('details')
                    ->orderBy('created_date', 'asc')
                    ->get();

                // 6. Lấy danh sách mã hoá đơn đã được xử lý trước đó
                $existingInvoiceCodes = HistoryPointEvent::where('customer_id', $customer->id)
                    ->pluck('code_order')
                    ->toArray();

                // 7. Duyệt qua hoá đơn và cập nhật điểm nếu chưa xử lý
                foreach ($invoices as $invoice) {
                    if (in_array($invoice->code, $existingInvoiceCodes)) {
                        continue;
                    }

                    foreach ($invoice->details as $invoiceDetail) {
                        $this->updateBuyAndGift($invoice, $invoiceDetail, $customer);
                    }
                }
            }

            // 8. Trả lại thông tin khách hàng
            $customer = Customer::select('id', 'kiotviet_id', 'code', 'name', 'contact_number', 'branch_id', 'total_point_event', 'used_point_event')
                ->find($customer->id);
            $data = $customer->total_point_event - $customer->used_point_event;

            return response()->json(['status' => true, 'data' => $data], Response::HTTP_OK);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json(['error' => $exception->errors()], 422);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Cập nhật điểm hoặc trừ điểm đổi quà theo chương trình mua là có quà
     */
    public function updateBuyAndGift($invoice, $invoiceDetail, $data_customer){
        try{
            $product = ProductsModel::where('code', $invoiceDetail->product_code)
                ->where('created_at', '<=', $invoice->created_date)
                ->first();

            //Cộng điểm khi mua sản phẩm và kiểm tra sản phẩm tặng hoặc khuyến mại thì không được cộng điểm.
            if (!empty($product) && (int)$invoiceDetail->discount == 0){
                $pointEvents = $product->point * $invoiceDetail->quantity;
                $historyPoint = new HistoryPointEvent([
                    'customer_id' => $data_customer->id,
                    'title' => "[Tích +$pointEvents"."Winxu] " . $product->name,
                    'code_order' => $invoice->code,
                    'product_id' => $invoiceDetail->product_id,
                    'product_code' => $invoiceDetail->product_code,
                    'product_name' => $invoiceDetail->product_name,
                    'point' => $pointEvents,
                    'type' => 1
                ]);
                $historyPoint->save();
                $data_customer->total_point_event += $pointEvents;
                $data_customer->save();
            }

            //Kiểm tra đơn hàng có quà tặng hay không. Nếu có thì trừ điểm đi và lưu lại lịch sử đổi quà tặng!
            if ((int)$invoiceDetail['subTotal'] == 0){
                $gift = GiftEvent::where('code', $invoiceDetail->product_code)
                    ->where('created_at', '<=', $invoice->created_date)
                    ->first();

                if (!empty($gift)){
                    $pointGift = $gift->point * $invoiceDetail->quantity;

                    //Lịch sử trừ điểm đổi quà
                    $historyPoint = new HistoryPointEvent([
                        'customer_id' => $data_customer->id,
                        'title' => "[Đổi -$pointGift"."Winxu] " . $gift->name,
                        'code_order' => $invoice->code,
                        'product_id' => $invoiceDetail->product_id,
                        'product_code' => $invoiceDetail->product_code,
                        'product_name' => $invoiceDetail->product_name,
                        'point' => $pointGift,
                        'type' => 2
                    ]);
                    $historyPoint->save();

                    //Lịch sử quà tặng
                    $exchange = new ExchangeGiftEvent([
                        'customer_id' => $data_customer->id,
                        'gift_id' => $gift->id,
                        'name_gift' => $gift->name,
                        'image_gift' => $gift->image,
                        'code_gift' => $gift->code,
                        'barcode_gift' => $gift->barcode ?? null,
                        'point' => $gift->point,
                        'quantity' => $invoiceDetail->quantity,
                        'status' => 2,
                        'branch_id' => $invoice->branch_id
                    ]);
                    $exchange->save();

                    $branch = Branch::where('kiotviet_id', $invoice->branch_id)->first();
                    if (!empty($branch)){
                        $quantityGift = QuantityGiftEvents::where('gift_events_id', $gift->id)->where('branch_id', $branch->id)->first();
                        if (!empty($quantityGift)){
                            $quantityGift->quantity = $quantityGift->quantity - $invoiceDetail->quantity;
                            $quantityGift->save();
                        }
                    }
                    $data_customer->used_point_event += $pointGift;
                    $data_customer->save();
                }
            }
        }catch (\Exception $exception){
            dd($exception);
        }
    }
    /**
     * Mua sản phẩm
    **/
    public function addToCart (Request $request)
    {
        if (empty($request->phone)){
            return \response()->json(['status' => false, 'msg' => 'Vui lòng điền số điện thoại khách hàng'], 401);
        }
        $customer = Customer::where('contact_number', $request->get('phone'))->first();
        $product = ProductsModel::find($request->get('product_id'));
        if (empty($product)){
            return \response()->json(['status' => false, 'msg' => 'Không tìm thấy sản phẩm.Vui lòng kiểm tra lại'], 401);
        }
        $image = json_decode($product->image);
        $cart = new CartModel([
            'customer_id' => $customer->id??null,
            'phone' => $request->get('phone'),
            'name_customer' => $request->get('name')??null,
            'name_product' => $product->name,
            'image_product' => $image[0],
            'code_product' => $product->code,
            'price' => $product->price,
            'status' => 1
        ]);
        $cart->save();
        return \response()->json(['status' => true, 'msg' => 'Yêu cầu mua sản phẩm thành công. Chúng tôi sẽ liên hệ với bạn sớm.Chân trọng cảm ơn'], 200);
    }

    public function listCart (Request $request)
    {
        $listData = CartModel::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('phone', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('name_customer', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('name_product', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('code_product', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        return view('product.list_cart', compact('listData'));
    }
}
