<?php


namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PharmacyController extends HelperApiController
{
    public function submitPrescription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'nullable|string',
            'note'       => 'nullable|string',
            'images.*'   => 'image|mimes:jpeg,png,jpg|max:2048',
            'images'     => 'array|max:3', // tối đa 3 ảnh
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $imagePaths = [];

        foreach ($request->file('images') as $file){
            $fileName = time().Str::random(10).'.'.$file->getClientOriginalExtension();
            $file->move('upload/pharmacy/prescription/', $fileName);
            $imagePaths[] = 'upload/pharmacy/prescription/'.$fileName;
        }

        $prescription = Prescription::create([
            'full_name'     => $request->full_name,
            'phone'    => $request->phone,
            'age'      => $request->age,
            'address'  => $request->address,
            'note'     => $request->note,
            'image'    => json_encode($imagePaths),
            'status'   => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Gửi đơn thuốc thành công!',
            'data' => $prescription,
        ]);
    }
}
