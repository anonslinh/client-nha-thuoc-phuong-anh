<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventsModel;
use App\Models\ProductsEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventsController extends Controller
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
}
