<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function all()
    {
        $customers = Customer::paginate(10);
        return response()->json($customers);
    }

    public function create(Request $request)
    {
        $validator = $this->validateCustomer($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            Customer::create($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    public function update(Request $request)
    {
        $validator = $this->validateCustomer($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $customer = Customer::findOrFail($request->id);
            $customer->update($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    private function validateCustomer(Request $request)
    {
        return Validator::make($request->all(), [
            'full_name' => 'required|min:5',
            'phone' => 'required',
        ]);
    }

    public function delete($id)
    {
        try {
            Customer::findOrFail($id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function getAsyncCustomers(Request $request)
    {
        $customers = Customer::select(['id', 'full_name'])
            ->where('full_name', 'LIKE', '%' . $request->name . '%')
            ->get();
        return response()->json($customers);
    }
}
