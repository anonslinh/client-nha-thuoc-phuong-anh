<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EventsModel;
use App\Models\ExchangeGiftEvent;
use App\Models\GiftEvent;
use App\Models\HistoryPointEvent;
use App\Models\ProductsEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
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
        return view('events.list-gift', compact('listData'));
    }
    /**
     * Tạo quà tặng
    **/
    public function createGift (Request $request)
    {
        try{
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift-event/', $nameFile);
            $gift = new GiftEvent([
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'point' => $request->get('point'),
                'quantity' => $request->get('quantity'),
                'barcode' => $request->get('barcode'),
                'active' => 1,
                'image' => 'upload/gift-event/'.$nameFile
            ]);
            $gift->save();
            return back()->with(['success' => 'Thêm quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm quà tặng thất bại.Vui lòng điền đầy đủ thông tin']);
        }
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
        $gift->quantity = $request->get('quantity');
        $gift->barcode = $request->get('barcode');
        $gift->save();
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
}
