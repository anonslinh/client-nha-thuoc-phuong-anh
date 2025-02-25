<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Admin\SyncController;
use App\Models\Customer;
use App\Models\EventsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventsController extends SyncController
{
    public function getDataCustomer (Request $request)
    {
        $events = EventsModel::whereDate('time_start', '<=', Carbon::now())->whereDate('time_end', '>=', Carbon::now())->get();
        $customerID = null;
        if (isset($request->phone)){
            $validatedData = $request->validate([
                'phone' => ['required', 'regex:/^(0[1-9][0-9]{8,9}|84[1-9][0-9]{8,9})$/'],
            ], [
                'phone.required' => 'Số điện thoại là bắt buộc.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
            ]);

            $phone = $this->normalizePhone($validatedData['phone']);
            $this->syncCustomerInvoices($phone);
            $customer = Customer::where('contact_number', $phone)->first();
            if (!empty($events)){
                foreach ($events as $value){
                    $this->SynchronizePoint($customer->kiotviet_id, $value);
                }
            }
            $customerID = $customer->id;
        }
        $data['events'] = $events;
        $data['customer'] = Customer::find($customerID);
        return response()->json(['status' => true, 'data' => $data], Response::HTTP_OK);
    }
}
