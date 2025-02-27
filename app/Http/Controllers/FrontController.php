<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Store;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\BookingTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StoreBookingPaymentRequest;

class FrontController extends Controller
{
    public function index()
    {
        $cities = City::all();
        $services = Service::with(['storeServices'])->get();

        return view('front.index', compact('cities', 'services'));
    }

    public function search(Request $request)
    {
        $cityId = $request->input('city_id');
        $serviceTypeId = $request->input('service_type');

        $service = Service::where('id', $serviceTypeId)->first();
        if (!$service) {
            return redirect()->back()->with('error', 'Service type not found.');
        }

        $stores = Store::whereHas('storeServices', function ($query) use ($service): void {
            $query->where('service_id', $service->id);
        })->where('city_id', $cityId)->get();

        $city = City::find($cityId);
        session()->put('serviceTypeId', $request->input('service_type'));

        return view('front.stores', [
            'stores' => $stores,
            'service' => $service,
            'cityName' => $city ? $city->name : 'Unknow City',
        ]);
    }

    public function details(Store $store)
    {
        $store->load('storePhotos');
        $serviceTypeId = session()->get('serviceTypeId');
        $service = Service::where('id', $serviceTypeId)->first();

        return view('front.details', compact('store', 'service'));
    }

    public function booking(Store $store)
    {
        session()->put('storeId', $store->id);

        $serviceTypeId = session()->get('serviceTypeId');
        $service = Service::where('id', $serviceTypeId)->first();

        return view('front.booking', compact('store', 'service'));
    }

    public function booking_store(StoreBookingRequest $request)
    {
        $customerName = $request->input('name');
        $customerPhoneNumber = $request->input('phone_number');
        $customerTimeAt = $request->input('time_at');

        session()->put('customerName', $customerName);
        session()->put('customerPhoneNumber', $customerPhoneNumber);
        session()->put('customerTimeAt', $customerTimeAt);

        $serviceTypeId = session()->get('serviceTypeId');
        $storeId = session()->get('storeId');

        return redirect()->route('front.booking.payment', [$storeId, $serviceTypeId]);
    }

    public function booking_payment(Store $store, Service $service)
    {
        $ppn = 0.11;
        $totalPpn = $service->price * $ppn;
        $bookingFee = 25000;
        $totalGrandTotal = ($bookingFee + $totalPpn) + $service->price;

        session()->put('totalAmount', $totalGrandTotal);
        return view('front.payment', compact('store', 'service', 'totalPpn', 'bookingFee', 'totalGrandTotal'));
    }

    public function booking_payment_store(StoreBookingPaymentRequest $request)
    {
        $customerName = session()->get('customerName');
        $customerPhoneNumber = session()->get('customerPhoneNumber');
        $totalAmount = session()->get('totalAmount');
        $customerTimeAt = session()->get('customerTimeAt');
        $serviceTypeId = session()->get('serviceTypeId');
        $storeId = session()->get('storeId');

        $bookingTransactionId = null;

        DB::transaction(function () use ($request, $totalAmount, $customerName, $customerPhoneNumber, $customerTimeAt, $serviceTypeId, $storeId, &$bookingTransactionId) {
            $validated = $request->validated();

            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['name'] = $customerName;
            $validated['total_amount'] = $totalAmount;
            $validated['phone_number'] = $customerPhoneNumber;
            $validated['started_at'] = Carbon::tomorrow()->format('Y-m-d');
            $validated['time_at'] = $customerTimeAt;
            $validated['service_id'] = $serviceTypeId;
            $validated['store_id'] = $storeId;
            $validated['is_paid'] = false;

            $newBooking = BookingTransaction::create($validated);
            $bookingTransactionId = $newBooking->id;
        });

        return redirect()->route('front.success.booking', $bookingTransactionId);
    }

    public function success_booking(BookingTransaction $bookingTransaction)
    {
        return view('front.success_booking', compact('bookingTransaction'));
    }

    public function transactions()
    {
        return view('front.transactions');
    }

    public function transaction_details(Request $request)
    {
        $request->validate([
            'trx_id' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        $trx_id = $request->input('trx_id');
        $phone_number = $request->input('phone_number');

        $details = BookingTransaction::with(['service_details', 'store_details'])->where('trx_id', $trx_id)->where('phone_number', $phone_number)->first();

        if (!$details) {
            return redirect()->back()->withErrors(['error' => 'Transactions not found.']);
        }

        $ppn = 0.11;
        $totalPpn = $details->service_details->price * $ppn;
        $bookingFee = 25000;

        return view('front.transactions_details', compact('details', 'totalPpn', 'bookingFee'));
    }
}
