<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Branch;
use App\Models\Gift;
use App\Models\MembershipLevel;
use App\Models\Program;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Illuminate\Support\of;

class GiftController
{
    public function index (Request $request)
    {
        $listData = Gift::query();
        if (isset($request->key_search)){
            $listData = $listData->where(function ($query) use ($request){
                $query->where('name', 'like', '%'.$request->get('key_search').'%')
                    ->orWhere('code', 'like', '%'.$request->get('key_search').'%');
            });
        }
        $listData = $listData->orderBy('updated_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            if (!empty($value->rank_id)){
                $rank = MembershipLevel::find($value->rank_id);
                $value['name_rank'] = $rank->name??'Hạng thẻ đã bị khóa';
            }
        }
        $rank = MembershipLevel::orderBy('spending_threshold', 'asc')->get();
        return view('gift.list-data', compact('listData', 'rank'));
    }

    public function store (Request $request)
    {
        try{
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift/', $nameFile);
            $gift = new Gift([
                'name' => $request->get('name'),
                'code' => $request->get('code'),
                'points_required' => $request->get('point'),
                'rank_id' => $request->get('rank_id'),
                'is_display' => 1,
                'image' => 'upload/gift/'.$nameFile
            ]);
            $gift->save();
            return back()->with(['success' => 'Thêm quà tặng thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm quà tặng thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Cập nhật quà tặng
    **/
    public function update (Request $request, $id)
    {
        $gift = Gift::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/gift/', $nameFile);
            if (file_exists(public_path($gift->image))) {
                unlink(public_path($gift->image));
            }
            $gift->image = 'upload/gift/'.$nameFile;
        }
        $gift->name = $request->get('name');
        $gift->code = $request->get('code');
        $gift->points_required = $request->get('point');
        $gift->rank_id = $request->get('rank_id');
        $gift->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Xóa quà tặng
    **/
    public function delete ($id)
    {
        $gift = Gift::find($id);
        if (empty($gift)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        $gift->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }
    /**
     * Danh sách banner
    **/
    public function banner (Request $request)
    {
        $listData = Banner::orderBy('created_at', 'desc')->paginate(20);

        $branches = Branch::all();
        return view('banner.index', compact('listData', 'branches'));
    }

    /**
     * Tạo mới banner
    **/
    public function storeBanner (Request $request)
    {
        try{
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/banner/', $nameFile);
            $banner = new Banner([
                'branch_id' => $request->get('branch_id'),
                'title' => $request->get('name'),
                'image_url' => 'upload/banner/'.$nameFile,
                'redirect_url' => $request->get('redirect_url'),
                'start_date' => $request->get('time_start'),
                'end_date' => $request->get('time_end')
            ]);
            $banner->save();
            return back()->with(['success' => 'Thêm banner thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm banner thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Cập nhật banner
    **/
    public function updateBanner (Request $request , $id)
    {
        $banner = Banner::find($id);
        if (empty($banner)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/banner/', $nameFile);
            if (file_exists(public_path($banner->image_url))) {
                unlink(public_path($banner->image_url));
            }
            $banner->image_url = 'upload/banner/'.$nameFile;
        }
        $banner->title = $request->get('name');
        $banner->branch_id = $request->get('branch_id');
        $banner->redirect_url = $request->get('link');
        $banner->start_date = $request->get('time_start');
        $banner->end_date = $request->get('time_end');
        $banner->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Xóa banner
    **/
    public function deleteBanner ($id)
    {
        $banner = Banner::find($id);
        if (empty($banner)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if (file_exists(public_path($banner->image_url))) {
            unlink(public_path($banner->image_url));
        }
        $banner->delete();
        return back()->with(['success' => 'Xóa banner thành công']);
    }
    /**
     * Danh sách chương trình
    **/
    public function program (Request $request)
    {
        $listData = Program::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        foreach ($listData as $value){
            $value->images = json_decode($value->images);
        }
        return view('program.index', compact('listData'));
    }

    /**
     * Tạo mới chương trình
    **/
    public function createProgram (Request $request)
    {
        return view('program.create');
    }
    public function storeProgram (Request $request)
    {
        try{
            $filePoster = $request->file('thumbnail');
            $nameFile = 'poster'.time().Str::random(10).'.'.$filePoster->getClientOriginalExtension();
            $filePoster->move('upload/program/', $nameFile);
            $dataImage = [];
            foreach ($request->file('images') as $file){
                $nameImage = 'image'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
                $file->move('upload/program/', $nameImage);
                array_push($dataImage, 'upload/program/'.$nameImage);
            }
            $program = new Program([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'branch_id' => $request->get('branch_id'),
                'thumbnail' => 'upload/program/'.$nameFile,
                'images' => json_encode($dataImage),
                'join_link' => $request->get('join_link'),
                'active_join_link' => isset($request->join_link) ? 1 : 0,
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date')
            ]);
            $program->save();
            return back()->with(['success' => 'Thêm chương trình thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm chương trình thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Chi tiết sự kiện
    **/
    public function detailProgram (Request $request, $id)
    {
        $program = Program::find($id);
        if (empty($program)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        $program->images = json_decode($program->images);
        return view('program.detail', compact('program'));
    }
    /**
     * Cập nhật sự kiện
    **/
    public function updateProgram (Request $request, $id)
    {
        try{
            $program = Program::find($id);
            if (empty($program)){
                return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
            }
            $dataImage = json_decode($program->images);
            if (!empty($request->image_delete)){
                $dataImageDelete = explode(',',$request->get('image_delete'));
                $dataImage = array_values(array_diff($dataImage, $dataImageDelete));
                foreach ($dataImageDelete as $imageDelete){
                    if (file_exists(public_path($imageDelete))) {
                        unlink(public_path($imageDelete));
                    }
                }
            }
            if ($request->hasFile('thumbnail')){
                if (file_exists(public_path($program->thumbnail))) {
                    unlink(public_path($program->thumbnail));
                }
                $filePoster = $request->file('thumbnail');
                $nameFile = 'poster'.time().Str::random(10).'.'.$filePoster->getClientOriginalExtension();
                $filePoster->move('upload/program/', $nameFile);
                $program->thumbnail = 'upload/program/'.$nameFile;
            }
            if ($request->hasFile('images')){
                foreach ($request->file('images') as $file){
                    $nameImage = 'image'.time().Str::random(10).'.'.$file->getClientOriginalExtension();
                    $file->move('upload/program/', $nameImage);
                    array_push($dataImage, 'upload/program/'.$nameImage);
                }
            }
            $program->title = $request->get('title');
            $program->join_link = $request->get('join_link')??null;
            $program->branch_id = $request->get('branch_id');
            $program->start_date = $request->get('start_date');
            $program->end_date = $request->get('end_date');
            $program->description = $request->get('description');
            $program->images = json_encode($dataImage);
            $program->save();
            return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Cập nhật dữ liệu thất bại.Vui lòng kiểm tra lại']);
        }
    }
    /**
     * Xóa dữ liệu sự kiện
    **/
    public function deleteProgram ($id)
    {
        $program = Program::find($id);
        if (empty($program)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        if (file_exists(public_path($program->thumbnail))) {
            unlink(public_path($program->thumbnail));
        }
        $dataImage = json_decode($program->images);
        foreach ($dataImage as $imageDelete){
            if (file_exists(public_path($imageDelete))) {
                unlink(public_path($imageDelete));
            }
        }
        $program->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }
    /**
     * Khuyến mại
    **/
    public function promotion (Request $request)
    {
        $listData = Promotion::query();
        if (isset($request->key_search)){
            $listData = $listData->where('title', 'like', '%'.$request->get('key_search').'%');
        }
        $listData = $listData->orderBy('created_at', 'desc')->paginate(20);
        return view('promotion.index', compact('listData'));
    }
    /**
     * Tạo khuyến mại
    **/
    public function createPromotion (Request $request)
    {
        return view('promotion.create');
    }
    public function storePromotion (Request $request)
    {
        try{
            $filePoster = $request->file('image_path');
            $nameFile = time().Str::random(10).'.'.$filePoster->getClientOriginalExtension();
            $filePoster->move('upload/promotion/', $nameFile);
            $program = new Promotion([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'sub_title' => $request->get('sub_title'),
                'image_path' => 'upload/promotion/'.$nameFile,
                'join_link' => $request->get('join_link'),
                'active_join_link' => isset($request->join_link) ? 1 : 0,
                'start_date' => $request->get('start_date'),
                'end_date' => $request->get('end_date')
            ]);
            $program->save();
            return back()->with(['success' => 'Thêm khuyến mại thành công']);
        }catch (\Exception $exception){
            return back()->with(['error' => 'Thêm khuyến mại thất bại.Vui lòng điền đầy đủ thông tin']);
        }
    }
    /**
     * Chi tiết khuyến mại
    **/
    public function detailPromotion ($id)
    {
        $promotion = Promotion::find($id);
        if (empty($promotion)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        return view('promotion.detail', compact('promotion'));
    }
    /**
     * Cập nhật khuyến mại
    **/
    public function updatePromotion (Request $request, $id)
    {
        $promotion = Promotion::find($id);
        if (empty($promotion)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        if ($request->hasFile('image_path')){
            if (file_exists(public_path($promotion->image_path))) {
                unlink(public_path($promotion->image_path));
            }
            $filePoster = $request->file('image_path');
            $nameFile = time().Str::random(10).'.'.$filePoster->getClientOriginalExtension();
            $filePoster->move('upload/promotion/', $nameFile);
            $promotion->image_path = 'upload/promotion/'.$nameFile;
        }
        $promotion->title = $request->get('title');
        $promotion->join_link = $request->get('join_link');
        $promotion->start_date = $request->get('start_date');
        $promotion->end_date = $request->get('end_date');
        $promotion->sub_title = $request->get('sub_title');
        $promotion->description = $request->get('description');
        $promotion->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
    /**
     * Xóa khuyến mại
    **/
    public function deletePromotion ($id)
    {
        $promotion = Promotion::find($id);
        if (empty($promotion)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu.Vui lòng kiểm tra lại']);
        }
        if (file_exists(public_path($promotion->image_path))) {
            unlink(public_path($promotion->image_path));
        }
        $promotion->delete();
        return back()->with(['success' => 'Xóa dữ liệu thành công']);
    }
}
