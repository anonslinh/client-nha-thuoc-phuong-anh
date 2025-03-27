<?php

namespace App\Http\Controllers;

use App\Models\Gift;
use App\Models\ProductGiftModel;
use App\Models\ProductsModel;
use App\Models\VideoYoutube;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class VideoProductController extends Controller
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
        $listVideo = VideoYoutube::where('is_active', 1)->orderBy('index', 'asc')->paginate(20);
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
        $point = Gift::orderBy('points_required', 'asc')->pluck('points_required')->toArray();
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
                'price' => $request->get('price'),
                'point' => $request->get('point'),
                'description' => $request->get('description'),
                'image' => json_encode($image)
            ]);
            $product->save();
            $dataGift = Gift::where('is_display', 1)->where('points_required', $request->get('point'))->select('id')->get();
            foreach ($dataGift as $gift){
                $productGift = new ProductGiftModel([
                    'products_id' => $product['id'],
                    'gifts_id' => $gift['id']
                ]);
                $productGift->save();
            }
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
        $point = Gift::orderBy('points_required', 'asc')->pluck('points_required')->toArray();
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
        ProductGiftModel::where('products_id', $id)->delete();
        $dataGift = Gift::where('is_display', 1)->where('points_required', $request->get('point'))->select('id')->get();
        foreach ($dataGift as $gift){
            $productGift = new ProductGiftModel([
                'products_id' => $id,
                'gifts_id' => $gift['id']
            ]);
            $productGift->save();
        }
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
        $listData = Gift::query();
        $listData = $listData->join('product_gift', 'product_gift.gifts_id', '=', 'gifts.id')->select('gifts.*');
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('gifts.name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('gifts.code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->where('product_gift.products_id', $id)->paginate(20);
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
}
