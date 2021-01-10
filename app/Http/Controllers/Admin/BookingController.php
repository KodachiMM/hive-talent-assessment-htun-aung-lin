<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Service;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function all()
    {
        $bookings = Booking::with('services')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return response()->json($bookings);
    }

    public function search($name)
    {
        $bookings = Booking::with('services')
            ->where('booking_date', 'LIKE', '%' . $name . '%')
            ->orWhere('customer_name', 'LIKE', '%' . $name . '%')
            ->orWhere('car_number', 'LIKE', '%' . $name . '%')
            ->orWhere('duration', 'LIKE', '%' . $name . '%')
            ->orWhere('booking_status', 'LIKE', '%' . $name . '%')
            ->orWhere('total_amount', 'LIKE', '%' . $name . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()->json($bookings);
    }

    public function create(Request $request)
    {
        $validator = $this->validateBooking($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $request['booking_date'] = Carbon::parse($request->booking_date)->format('Y-m-d');
            $request['verification_number'] = strtoupper(substr(str_shuffle(MD5(microtime())), 0, 8));
            $request['total_amount'] = $this->calculateTotalAmount($request->services);

            $booking = Booking::create($request->except('services'));

            $booking->services()->attach($request->services);

            // Verification Number SMS API here //

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return $e;
            return response()->json(['status' => false], 200);
        }
    }

    public function update(Request $request)
    {
        $validator = $this->validateBooking($request);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        try {
            $request['booking_date'] = Carbon::parse($request->booking_date)->format('Y-m-d');
            $request['total_amount'] = $this->calculateTotalAmount($request->services);

            $booking = Booking::findOrFail($request->id);

            $booking->update($request->except('services'));
            $booking->update($request->all());

            $booking->services()->detach();
            $booking->services()->attach($request->services);

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }

    private function validateBooking(Request $request)
    {
        return Validator::make($request->all(), [
            'booking_date' => 'required|date_format:d M Y',
            'customer_id' => 'required',
            'customer_name' => 'required',
            'car_number' => 'required',
            'duration' => 'required|integer|min:1|max:30',
            'services' => 'required',
        ]);
    }

    private function calculateTotalAmount($services)
    {
        $total_amount = 0;

        foreach ($services as $service) {
            $amount = Service::where('id', $service)->value('price');
            $total_amount += $amount;
        }

        return $total_amount;
    }

    public function delete($id)
    {
        try {
            Booking::findOrFail($id)->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }
    }

    public function completeBooking(Request $request)
    {
        try {
            $booking = Booking::findOrFail($request->id);
            $booking->update(['booking_status' => 'Complete']);

            // Car Pick Up SMS API here //

            return response()->json(['status' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false], 200);
        }
    }
}
