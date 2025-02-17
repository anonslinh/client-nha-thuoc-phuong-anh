<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Models\Gift;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Illuminate\Support\of;

class GiftController
{
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
     * Danh sách banner
    **/
    public function banner (Request $request)
    {
        $listData = Banner::orderBy('created_at', 'desc')->paginate(20);
        return view('banner.index', compact('listData'));
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
            dd($exception->getMessage());
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
}
