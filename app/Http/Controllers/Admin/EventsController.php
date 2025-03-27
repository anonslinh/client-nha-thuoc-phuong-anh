<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\EventsModel;
use App\Models\ExchangeGiftEvent;
use App\Models\GiftEvent;
use App\Models\HistoryPointEvent;
use App\Models\ProductsEvent;
use App\Models\QuantityGiftEvents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventsController extends SyncController
{
    public function listData (Request $request)
    {
        $listData = EventsModel::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        if (isset($request->time_start) && isset($request->time_end)){
            $listData = $listData->where('time_start', '>=', $request->get('time_start'))->where('time_end', '<=', $request->get('time_end'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $value->total_product = ProductsEvent::where('events_id', $value->id)->count();
            $value->images = json_decode($value->images);
        }
        return view('events.list_data', compact('listData'));
    }
    public function create ()
    {
        return view('events.create');
    }
    public function store (Request $request)
    {
        try{
            $dataImage = [];
            foreach ($request->file('images') as $file){
                $nameImage = 'image'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/events/', $nameImage);
                array_push($dataImage, 'upload/events/'.$nameImage);
            }
            $events = new EventsModel([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'time_start' => $request->get('start_date'),
                'time_end' => $request->get('end_date'),
                'images' => json_encode($dataImage)
            ]);
            $events->save();
            return back()->with(['success' => 'Tạo sự kiện thành công']);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return back()->with(['error' => 'Tạo sự kiện thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }

    public function detail (Request $request, $id)
    {
        $events = EventsModel::find($id);
        if (empty($events)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $events->images = json_decode($events->images);
        return view('events.detail', compact('events'));
    }

    public function update (Request $request, $id)
    {
        $events = EventsModel::find($id);
        if (empty($events)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $dataImage = json_decode($events->images);
        if (!empty($request->image_delete)){
            $dataImageDelete = explode(',',$request->get('image_delete'));
            $dataImage = array_values(array_diff($dataImage, $dataImageDelete));
            foreach ($dataImageDelete as $imageDelete){
                if (file_exists(public_path($imageDelete))) {
                    unlink(public_path($imageDelete));
                }
            }
        }
        if ($request->hasFile('images')){
            foreach ($request->file('images') as $file){
                $nameImage = 'image'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/events/', $nameImage);
                array_push($dataImage, 'upload/events/'.$nameImage);
            }
        }
        $events->title = $request->get('title');
        $events->description = $request->get('description');
        $events->images = json_encode($dataImage);
        $events->time_start = $request->get('start_date');
        $events->time_end = $request->get('end_date');
        $events->save();
        return back()->with(['success' => 'Cập nhật sự kiện thành công']);
    }

    public function delete ($id)
    {
        $events = EventsModel::find($id);
        if (empty($events)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $dataImage = json_decode($events->images);
        foreach ($dataImage as $imageDelete){
            if (file_exists(public_path($imageDelete))) {
                unlink(public_path($imageDelete));
            }
        }
        $events->delete();
        ProductsEvent::where('events_id', $id)->delete();
        return back()->with(['success' => 'Xóa sự kiện thành công']);
    }

    public function addProduct (Request $request, $id)
    {
        $events = EventsModel::find($id);
        if (empty($events)){
            return back()->with(['error' => 'Dữ liệu không tồn tại.Vui lòng kiểm tra lại']);
        }
        $token = $this->kiotVietService->getAccessToken();
        $nameShop = $this->kiotVietService->getRetailer();
        $endpoint = 'https://public.kiotapi.com/products';
        $pageSize = 20;
        $currentPage  = $request->page??1;
        $currentItem = ($currentPage - 1) * $pageSize;
        $Category_id = $request->id_category??'';
        $name = $request->get('key_search')??'';
        $response = Http::withHeaders([
            'Retailer' => $nameShop,
            'Authorization' => 'Bearer ' . $token,
        ])->get($endpoint,[
            'pageSize' => $pageSize,
            'currentItem' => $currentItem,
            'categoryId' => $Category_id,
            'name' => $name
        ]);
        $products  = $response->json();
        $totalItems = $products['total'];
        $paginator = collect($products['data']);
        $paginator = new LengthAwarePaginator(
            $paginator,
            $totalItems,
            $pageSize,
            $currentPage,
            ['path' => url()->current(), 'query' => $request->except('page')]
        );
        foreach ($paginator as $value){
            $value['check'] = ProductsEvent::where('events_id', $id)->where('product_id', $value['id'])->exists();
        }
        $categories = $this->getCategories();
        $dataCategoryNew = [];
        if ($categories['total'] > $categories['pageSize']){
            $numberItem = $categories['total'] / $categories['pageSize'];
            $page = explode('.', $numberItem);
            for ($i = 1; $i <= $page[0]; $i++){
                $currentItemCategory = $categories['pageSize'] * $i;
                $categoriesNew = $this->getCategories($currentItemCategory);
                $dataCategoryNew = $categoriesNew['data'];
            }
        }
        $categories = array_merge($categories['data'], $dataCategoryNew);

        return view('events.product-kiotviet', compact('paginator', 'categories', 'events'));
    }
    /**
     * Thêm sản phẩm vào trong sự kiện
    **/
    public function createProduct (Request $request)
    {
        try{
            if (empty($request->products)){
                return \response()->json(['status' => false, 'msg' => 'Vui lòng điền đầy đủ thông tin'], Response::HTTP_BAD_REQUEST);
            }
            foreach ($request->get('products') as $value){
                $productKiotviet = $this->detailProductKiotViet($value['product_id']);
                $product = ProductsEvent::where('events_id', $request->get('events_id'))->where('product_id', $value['product_id'])->first();
                if (empty($product)){
                    $product = new ProductsEvent([
                        'events_id' => $request->get('events_id'),
                        'product_id' => $value['product_id'],
                        'point' => $value['point'],
                        'product_code' => $productKiotviet['code']??$productKiotviet['barCode'],
                        'name' => $productKiotviet['name'],
                        'base_price' => $productKiotviet['basePrice']
                    ]);
                }else{
                    $product->point = $value['point'];
                    $product->name = $productKiotviet['name'];
                    $product->product_code = $productKiotviet['code']??$productKiotviet['barCode'];
                    $product->base_price = $productKiotviet['basePrice'];
                }
                $product->save();
            }
            return \response()->json(['status' => true, 'msg' => 'Thêm sản phẩm vào sự kiện thành công'], Response::HTTP_OK);
        }catch (\Exception $exception){
            return response()->json(['status' => false, 'msg' => 'Đã có lỗi xảy ra.Xin vui lòng thử lại'], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Danh sách sản phẩm
    **/
    public function listProduct (Request $request)
    {
        $listData = ProductsEvent::query();
        if (isset($request->events_id)){
            $listData = $listData->where('events_id', $request->get('events_id'));
        }
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('name', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('product_code', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('product_id', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $value->events = EventsModel::find($value->events_id)->title ?? 'Sự kiện đã bị xóa';
        }
        $events = EventsModel::orderBy('created_at', 'desc')->get();
        return view('events.list-product', compact('listData', 'events'));
    }
    /**
     * Xóa sản phẩm trong sự kiện
    **/
    public function deleteProduct ($id)
    {
        $product = ProductsEvent::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Sản phẩm không tồn tại']);
        }
        $product->delete();
        return back()->with(['success' => 'Xóa sản phẩm thành công']);
    }
    /**
     * Cập nhật sản phẩm
    **/
    public function updateProduct (Request $request, $id)
    {
        $product = ProductsEvent::find($id);
        if (empty($product)){
            return back()->with(['error' => 'Sản phẩm không tồn tại']);
        }
        $product->point = $request->get('point');
        $product->save();
        return back()->with(['success' => 'Cập nhật điểm thành công']);
    }
    /**
     * Danh sách khách hàng
    **/
    public function listCustomer (Request $request)
    {
        $listData = Customer::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('kiotviet_id', 'like','%'.$request->get('key_search').'%')
                   ->orWhere('code', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('name', 'like', '%'.$request->get('key_search').'%')
                   ->orWhere('contact_number', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('updated_at', 'desc')->paginate(20);
        return view('events.customer', compact('listData'));
    }
    /**
     * Đồng bộ điểm cho khách
    **/
    public function updatePoint (Request $request)
    {
        $customer = Customer::where('kiotviet_id', $request->get('customer_id'))->first();
        if (empty($customer)){
            return \response()->json(['status' => false, 'msg' => 'Khách hàng không tồn tại'], Response::HTTP_BAD_REQUEST);
        }
        $events = EventsModel::whereDate('time_start', '<=', Carbon::now())->whereDate('time_end', '>=', Carbon::now())->get();
        if (empty($events)){
            return \response()->json(['status' => false, 'msg' => 'Không có chương trình nào cho thời gian hiện tại'], Response::HTTP_BAD_REQUEST);
        }
        foreach ($events as $value){
            $this->SynchronizePoint($request->get('customer_id'),$value);
        }
        return \response()->json(['status' => true, 'msg' => 'Đồng bộ điểm khách hàng vào hệ thống thành công'], Response::HTTP_OK);
    }
    /**
     * Lịch sủ điểm của khách hàng
    **/
    public function historyPoint (Request $request)
    {
        $listData = HistoryPointEvent::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('customer_id', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('title', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code_order', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('product_id', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('product_name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('product_code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $customer = Customer::where('kiotviet_id', $value->customer_id)->first();
            $value['name_customer'] = $customer->name??'';
            $value['code_customer'] = $customer->code??'';
            $value['phone_customer'] = $customer->contact_number??'';
        }
        return view('events.history-point', compact('listData'));
    }
    /**
     * Sửa điểm cho khách hàng
    **/
    public function customerUpdatePoint (Request $request)
    {
        $customer = Customer::find($request->get('customer_id'));
        if (empty($customer)){
            return back()->with(['error' => 'Không tìm thấy khách hàng.Vui lòng kiểm tra lại']);
        }
        if ($request->get('type') == 1){
            $title = 'Hệ thống cộng điểm cho khách';
            $customer->total_point_event = $customer->total_point_event + $request->get('point');
        }else{
            $title = 'Hệ thống trừ điểm';
            $customer->used_point_event = $customer->used_point_event + $request->get('point');
        }
        $customer->save();
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $history = new HistoryPointEvent([
            'customer_id' => $customer->kiotviet_id,
            'title' => $title,
            'code_order' => substr(str_shuffle($characters), 0, 11),
            'point' => $request->get('point'),
            'type' => $request->get('type')
        ]);
        $history->save();
        return back()->with(['success' => 'Cập nhật điểm khách hàng thành công']);
    }

    /**
     * Danh sách quà tặng
    **/
    public function listGift (Request $request)
    {
        $listData = GiftEvent::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('name', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('code', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('barcode', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->active)){
            $listData = $listData->where('active', $request->get('active'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $value->quantity = QuantityGiftEvents::where('gift_events_id', $value->id)->sum('quantity');
        }
        return view('events.list-gift', compact('listData'));
    }
    public function viewCreateGift ()
    {
        $listBranch = Branch::all();
        return view('events.create-gift', compact('listBranch'));
    }
    /**
     * Tạo quà tặng
    **/
    public function createGift (Request $request)
    {
        try{
            $checkQuantity = true;
            if (!empty($request->branch)){
                foreach ($request->branch as $value){
                    if ( !empty($value['quantity']) && (int)$value['quantity'] > 0){
                        $checkQuantity = false;
                    }
                }
            }
            if ($checkQuantity){
                return back()->with(['error' => 'Vui lòng điền số lượng quà tặng ít nhất cho một chi nhánh']);
            }
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-event/', $nameFile);
            $gift = new GiftEvent([
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'point' => $request->get('point'),
                'barcode' => $request->get('barcode'),
                'active' => 1,
                'image' => 'upload/gift-event/'.$nameFile
            ]);
            $gift->save();
            foreach ($request->get('branch') as $value){
                if ( !empty($value['quantity']) && (int)$value['quantity'] > 0){
                    $quantityGift = new QuantityGiftEvents([
                        'gift_events_id' => $gift['id'],
                        'branch_id' => $value['id'],
                        'quantity' => $value['quantity']
                    ]);
                    $quantityGift->save();
                }
            }
            return back()->with(['success' => 'Thêm quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm quà tặng thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Chi tiết quà tặng
    **/
    public function detailGift ($id)
    {
        $gift = GiftEvent::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Dữ liệu không tồn tại']);
        }
        $listBranch = Branch::all();
        foreach ($listBranch as $value){
            $quantity = QuantityGiftEvents::where('gift_events_id', $id)->where('branch_id', $value->id)->first();
            $value['quantity'] = $quantity->quantity??null;
        }
        return view('events.detail-gift', compact('gift', 'listBranch'));
    }
    /**
     * Cập nhât quà tặng
    **/
    public function updateGift (Request $request, $id)
    {
        $gift = GiftEvent::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        $checkQuantity = true;
        if (!empty($request->branch)){
            foreach ($request->branch as $value){
                if ( !empty($value['quantity']) && (int)$value['quantity'] > 0){
                    $checkQuantity = false;
                }
            }
        }
        if ($checkQuantity){
            return back()->with(['error' => 'Vui lòng điền số lượng quà tặng ít nhất cho một chi nhánh']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-event/', $nameFile);
            if (file_exists(public_path($gift->image))) {
                unlink(public_path($gift->image));
            }
            $gift->image = 'upload/gift-event/'.$nameFile;
        }
        $gift->name = $request->get('name');
        $gift->code = $request->get('code');
        $gift->point = $request->get('point');
        $gift->quantity = $request->get('quantity')??0;
        $gift->barcode = $request->get('barcode');
        $gift->description = $request->get('description');
        $gift->save();
        QuantityGiftEvents::where('gift_events_id', $id)->delete();
        foreach ($request->get('branch') as $value){
            if ( !empty($value['quantity']) && (int)$value['quantity'] > 0){
                $quantityGift = new QuantityGiftEvents([
                    'gift_events_id' => $id,
                    'branch_id' => $value['id'],
                    'quantity' => $value['quantity']
                ]);
                $quantityGift->save();
            }
        }
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Xóa quà tặng
     **/
    public function deleteGift ($id)
    {
        $gift = GiftEvent::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        $gift->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }
    /**
     * Lịch sử đổi quà của khách hàng
    **/
    public function historyExchangeGift (Request $request)
    {
        $listData = ExchangeGiftEvent::query();
        $listData = $listData->join('customers', 'customers.kiotviet_id', '=', 'exchange_gift_event.customer_id')->select('exchange_gift_event.*', 'customers.name', 'customers.code', 'customers.contact_number');
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
               $query->where('customers.contact_number', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('customers.name', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('customers.code', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('exchange_gift_event.name_gift', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('exchange_gift_event.code_gift', 'like', '%'.$request->get('key_search').'%')
               ->orWhere('exchange_gift_event.barcode_gift', 'like', '%'.$request->get('key_search').'%');
            });
        }
        if (isset($request->status)){
            $listData = $listData->where('exchange_gift_event.status', $request->get('status'));
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        return view('events.exchange-gift', compact('listData'));
    }

    /**
     * Thêm sản phẩm vào sự kiện theo nhóm hàng
    **/
    public function createProductWithCategory (Request $request)
    {
        try{
            $rule = [
                'events_id' => 'required|exists:events,id',
                'point' => 'required|numeric|min:1',
                'category_id' => 'required'
            ];
            $message = [
                'events_id.required' => 'Vui lòng chọn sự kiện',
                'events_id.exists' => 'Sự kiện không tồn tại.Vui lòng kiểm tra lại',
                'point.required' => 'Vui lòng điền số điểm',
                'point.numeric' => 'Vui lòng điền số điểm',
                'point.min' => 'Điêm nhỏ nhất phải là 1',
                'category_id.required' => 'Vui lòng chọn danh mục sản phẩm',
            ];
            $validation = Validator::make($request->all(), $rule, $message);
            if ($validation->fails()){
                return \response()->json(['status' => false, 'msg' => $validation->errors()->first()], Response::HTTP_BAD_REQUEST);
            }
            $token = $this->kiotVietService->getAccessToken();
            $nameShop = $this->kiotVietService->getRetailer();
            $endpoint = 'https://public.kiotapi.com/products';
            $pageSize = 100;
            $currentPage  = $request->page??1;
            $currentItem = ($currentPage - 1) * $pageSize;
            $Category_id = $request->get('category_id');
            $response = Http::withHeaders([
                'Retailer' => $nameShop,
                'Authorization' => 'Bearer ' . $token,
            ])->get($endpoint,[
                'pageSize' => $pageSize,
                'currentItem' => $currentItem,
                'categoryId' => $Category_id,
            ]);
            $listProduct  = $response->json();
            $dataProduct = [];
            if (!empty($listProduct['data'])){
                if ($listProduct['total'] > $pageSize){
                    $number = explode('.', $listProduct['total'] / $pageSize);
                    if ($number[0] > 1){
                        for ($i = 1; $i <= $number[0] + 1; $i++){
                            $currentItem = $i * $pageSize;
                            $response = Http::withHeaders([
                                'Retailer' => $nameShop,
                                'Authorization' => 'Bearer ' . $token,
                            ])->get($endpoint,[
                                'pageSize' => $pageSize,
                                'currentItem' => $currentItem,
                                'categoryId' => $Category_id,
                            ]);
                            $listProductItem = $response->json();
                            if (!empty($listProductItem['data'])){
                                foreach ($listProductItem['data'] as $item){
                                    $dataProduct[] = [
                                        'events_id' => $request->get('events_id'),
                                        'product_id' => $item['id'],
                                        'product_code' => $item['code'],
                                        'name' => $item['name'],
                                        'base_price' => $item['basePrice'],
                                        'price' => $item['basePrice'],
                                        'point' => $request->get('point'),
                                        'is_active' => 1,
                                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                                        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                                    ];
                                }
                            }
                        }
                    }
                }
                foreach ($listProduct['data'] as $value){
                    $dataProduct[] = [
                        'events_id' => $request->get('events_id'),
                        'product_id' => $value['id'],
                        'product_code' => $value['code'],
                        'name' => $value['name'],
                        'base_price' => $value['basePrice'],
                        'price' => $value['basePrice'],
                        'point' => $request->get('point'),
                        'is_active' => 1,
                        'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                    ];
                }
            }
            if (count($dataProduct)){
                DB::table('products_event')->upsert($dataProduct,['events_id', 'product_id'], ['product_code', 'name', 'base_price', 'price', 'point', 'is_active', 'updated_at']);
                return \response()->json(['status' => true, 'msg' => 'Thêm sản phẩm thành công'],Response::HTTP_OK);
            }else{
                return \response()->json(['status' => false, 'msg' => 'Không tìm thấy sản phẩm.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
            }
        }catch (\Exception $exception){
            return \response()->json(['status' => false, 'msg' => 'Thêm sản phẩm thất bại.Vui lòng kiểm tra lại'], Response::HTTP_BAD_REQUEST);
        }
    }
}
