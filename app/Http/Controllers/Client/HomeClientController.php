<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Room;

class HomeClientController extends Controller
{
    public function index()
{
    $rooms = Room::query()
        ->select('id','name','number_rooms')
        ->orderBy('id','asc')
        ->get();

    return view('client.home.index', compact('rooms'));
}
}