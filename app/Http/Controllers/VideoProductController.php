<?php

namespace App\Http\Controllers;

use App\Models\VideoYoutube;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
