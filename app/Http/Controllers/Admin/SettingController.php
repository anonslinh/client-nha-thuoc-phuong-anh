<?php


namespace App\Http\Controllers\Admin;


use App\Models\Branch;
use App\Models\Contacts;
use App\Models\Employee;
use App\Models\Slogan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends SyncController
{
    /**
     * danh sách nhân viên
    */
    public function getEmployees(){

        $listData = Employee::orderBy('created_at', 'desc')->paginate(20);
        $totalEmployees = $listData->total(); // Lấy tổng số nhân viên

        return view('config.employees-sync', compact('listData', 'totalEmployees'));
    }

    /**
     * danh sách chi nhánh
    */
    public function getBranches(){

        $listData = Branch::orderBy('created_at', 'desc')->paginate(20);
        $totalBranches = $listData->total();
        return view('config.branches-sync', compact('listData', 'totalBranches'));
    }

    /**
     * Liên hệ & phản hồi
    */
    public function getContacts(){
        $listData = Contacts::all();
        return view('config.contacts', compact('listData'));
    }

    /**
     * Cập nhật phản hồi & liên hệ
    */
    public function updateContact (Request $request, $id)
    {
        $data = Contacts::find($id);
        if (empty($data)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        if ($request->hasFile('image')){
            $file = $request->file('image');
            $nameFile = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/config/', $nameFile);
            $data->icon = 'upload/config/'.$nameFile;
        }
        $data->name = $request->get('name');
        $data->value = $request->get('value');
        $data->save();
        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }

    /**
     * Slogan
    */
    public function getSlogan(){
        $listData = Slogan::all();
        return view('config.slogan', compact('listData'));
    }

    /**
     * Cập nhật phản hồi & liên hệ
     */
    public function updateSlogan (Request $request, $id)
    {
        $data = Slogan::find($id);
        if (empty($data)){
            return back()->with(['error' => 'Không tìm thấy dữ liệu']);
        }
        $data->title = $request->get('title');
        $data->save();

        return back()->with(['success' => 'Cập nhật dữ liệu thành công']);
    }
}
