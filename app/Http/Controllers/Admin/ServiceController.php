<?php

namespace App\Http\Controllers\Admin;

use App\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function all()
    {
        $services = Service::paginate(10);
        return response()->json($services);
    }

    public function create(Request $request)
    {
        $validator = $this->validateService($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            Service::create($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    public function update(Request $request)
    {
        $validator = $this->validateService($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $service = Service::findOrFail($request->id);
            $service->update($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    private function validateService(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|min:5',
            'price' => 'required|numeric',
        ]);
    }

    public function delete($id)
    {
        try {
            Service::findOrFail($id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function getServices()
    {
        $services = Service::all();
        return response()->json($services);
    }
}
