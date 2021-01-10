<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function all()
    {
        $admins = Admin::paginate(10);
        return response()->json($admins);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|min:5',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $request['password'] = Hash::make($request->password);
            Admin::create($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'full_name' => 'required|min:5',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $admin = Admin::findOrFail($request->id);
            $admin->update($request->all());

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    public function delete($id)
    {
        try {
            $admin = Admin::findOrFail($id);

            if ($admin->id === Auth::guard('admin')->user()->id) {
                return response()->json(['success' => false, 'message' => 'You cannot delete yourself.']);
            }

            $admin->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }
}
