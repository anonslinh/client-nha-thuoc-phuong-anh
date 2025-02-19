<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventsModel;
use App\Models\ProductsEvent;
use Illuminate\Http\Request;

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
        }
        return view('events.list_data', compact('listData'));
    }
    public function create ()
    {
        return view('events.create');
    }
}
