<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoomsClientController extends Controller
{
    public function index()
    {
        return view('client.rooms.index');
    }
    public function detailRooms($id)
    {
        return view('client.rooms.detail');
    }
}