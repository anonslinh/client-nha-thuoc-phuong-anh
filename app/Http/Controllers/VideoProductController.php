<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SyncController;
use App\Http\Controllers\API\HelperApiController;
use App\Models\Customer;
use App\Models\Gift;
use App\Models\GiftEvent;
use App\Models\ProductsModel;
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
            $value['image'] = json_decode($value->id);
        }
        return \response()->json(['status' => true, 'data' => [
            'gift' => $gift,
            'list_product' => $listProduct
        ]], Response::HTTP_OK);
    }
    /**
     * Lấy thông tin người dùng winxu
    **/
    public function infoCustomer (Request $request, HelperApiController $helperApiController)
    {
        $validatedData = $request->validate([
            'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
        ], [
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
        ]);
        $phone = $helperApiController->normalizePhone($validatedData['phone']);
        $customer = Customer::where('contact_number', $phone)->first();
        $customerID = $customer->id??null;
        $listsProduct = ProductsModel::where('is_active', 1)->get();
        if (!empty($listsProduct) && !empty($customer)){
            foreach ($listsProduct as $value){
                $this->SynchronizePoint($customer->kiotviet_id, $value);
            }
        }
        $data['customer'] = Customer::find($customerID);
        return response()->json(['status' => true, 'data' => $data], Response::HTTP_OK);
    }
}
