<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Overtime;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    // Display a listing of bookings
    public function index()
    {
        $bookings = Booking::with(['item', 'user', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get(); // ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    // Show the form for creating a new booking
    // public function create()
    // {
    //     $items = Item::all();
    //     return view('bookings.create', compact('items'));
    // }
    public function create(Request $request)
    {
        $item_slug = $request->item_slug;

        // Jika ada item_slug, langsung ambil item tersebut
        if ($item_slug) {
            $item = Item::where('slug', $item_slug)->firstOrFail();
            return view('bookings.create', compact('item'));
        }

        // Jika tidak ada item_slug, tampilkan semua item (untuk case lain)
        $items = Item::all();
        return view('bookings.create', compact('items'));
    }

    // Store a newly created booking
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'region' => 'required|in:Jateng,DIY,Luar Provinsi',
            'driver_option' => 'required|in:With Driver,Without Driver',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calculate duration in days (24-hour periods starting from evening)
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $durationDays = $startDate->diffInDays($endDate);

        // Validate minimum rental period for out of region
        if ($request->region === 'Luar Provinsi' && $durationDays < 2) {
            return redirect()->back()
                ->with('error', 'Untuk luar provinsi minimal sewa 2 hari.')
                ->withInput();
        }

        $item = Item::findOrFail($request->item_id);

        // Calculate base price (price per day from item)
        $basePrice = $item->price * $durationDays;

        // Calculate driver fee based on region
        $driverFee = 0;
        if ($request->driver_option === 'With Driver') {
            $driverFee = ($request->region === 'Jateng') ? 200000 * $durationDays : 250000 * $durationDays;
        }

        // Calculate out of region fee
        $outOfRegionFee = ($request->region === 'Luar Provinsi') ? 50000 * $durationDays : 0;

        // Calculate total price
        $totalPrice = $basePrice + $driverFee + $outOfRegionFee;

        // Create booking
        $booking = Booking::create([
            'slug' => Str::slug(Str::random(10)),
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'region' => $request->region,
            'driver_option' => $request->driver_option,
            'status' => 'Pending',
            'base_price' => $basePrice,
            'driver_fee' => $driverFee,
            'out_of_region_fee' => $outOfRegionFee,
            'overtime_fee' => 0,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        return redirect()->route('bookings.show', $booking->slug)
            ->with('success', 'Booking created successfully. Please proceed with payment.');
    }

    // Display the specified booking
    public function show($slug)
    {
        $booking = Booking::with(['item', 'user', 'payment', 'overtime'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('bookings.show', compact('booking'));
    }

    // Show the form for editing the specified booking
    public function edit($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();
        $items = Item::all();

        return view('bookings.edit', compact('booking', 'items'));
    }

    // Update the specified booking
    public function update(Request $request, $slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        // Only allow updates for pending bookings
        if ($booking->status !== 'Pending') {
            return redirect()->back()
                ->with('error', 'Hanya booking dengan status Pending yang dapat diubah.');
        }

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'region' => 'required|in:Jateng,DIY,Luar Provinsi',
            'driver_option' => 'required|in:With Driver,Without Driver',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Recalculate all prices
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();
        $durationDays = $startDate->diffInDays($endDate);

        // Validate minimum rental period for out of region
        if ($request->region === 'Luar Provinsi' && $durationDays < 2) {
            return redirect()->back()
                ->with('error', 'Untuk luar provinsi minimal sewa 2 hari.')
                ->withInput();
        }

        $item = Item::findOrFail($request->item_id);
        $basePrice = $item->price * $durationDays;

        $driverFee = 0;
        if ($request->driver_option === 'With Driver') {
            $driverFee = ($request->region === 'Jateng') ? 200000 * $durationDays : 250000 * $durationDays;
        }

        $outOfRegionFee = ($request->region === 'Luar Provinsi') ? 50000 * $durationDays : 0;
        $totalPrice = $basePrice + $driverFee + $outOfRegionFee;

        $booking->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $durationDays,
            'item_id' => $item->id,
            'region' => $request->region,
            'driver_option' => $request->driver_option,
            'base_price' => $basePrice,
            'driver_fee' => $driverFee,
            'out_of_region_fee' => $outOfRegionFee,
            'total_price' => $totalPrice,
            'notes' => $request->notes,
        ]);

        return redirect()->route('bookings.show', $booking->slug)
            ->with('success', 'Booking updated successfully.');
    }

    // Remove the specified booking
    public function destroy($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        // Only allow deletion for pending bookings
        if (!in_array($booking->status, ['Pending', 'Cancelled'])) {
            return redirect()->back()
                ->with('error', 'Hanya booking dengan status Pending yang dapat dihapus.');
        }

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    // Confirm booking (admin action)
    public function confirm($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        if ($booking->status !== 'Pending') {
            return redirect()->back()
                ->with('error', 'Hanya booking dengan status Pending yang dapat dikonfirmasi.');
        }

        $booking->update(['status' => 'Confirmed']);

        return redirect()->back()
            ->with('success', 'Booking confirmed successfully.');
    }

    public function markAsOnRent($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        if ($booking->status !== 'Confirmed') {
            return redirect()->back()
                ->with('error', 'Booking harus dalam status Confirmed untuk bisa mulai disewa.');
        }

        if (!$booking->is_paid) {
            return redirect()->back()
                ->with('error', 'Booking harus sudah dibayar untuk bisa mulai disewa.');
        }

        $booking->update(['status' => 'On Rent']);

        return redirect()->back()
            ->with('success', 'Booking status updated to On Rent.');
    }

    // Mark booking as Completed (admin action)
    public function markAsCompleted(Request $request, $slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        if ($booking->status !== 'On Rent') {
            return redirect()->back()
                ->with('error', 'Hanya booking dengan status On Rent yang dapat diselesaikan.');
        }

        $validator = Validator::make($request->all(), [
            'actual_end_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Parse the actual end date with time
        $actualEndDate = Carbon::parse($request->actual_end_date);

        // Update booking status to Completed
        $booking->update([
            'status' => 'Completed',
            'actual_end_date' => $actualEndDate,
            'is_overtime' => false // Default false, akan diupdate jika ada overtime
        ]);

        // Hitung overtime jika ada
        $overtimeData = $booking->calculateOvertime();

        if ($overtimeData) {
            $booking->overtime()->create([
                'hours' => $overtimeData['hours'],
                'fee_per_hour' => $overtimeData['fee_per_hour'],
                'total_fee' => $overtimeData['total_fee'],
                'description' => 'Terlambat pengembalian'
            ]);

            $booking->update([
                'overtime_fee' => $overtimeData['total_fee'],
                'total_price' => $booking->total_price + $overtimeData['total_fee'],
                'is_overtime' => true
            ]);
        }

        return redirect()->back()
            ->with('success', 'Booking completed successfully.');
    }

    // Cancel booking
    public function cancel($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        if (!in_array($booking->status, ['Pending', 'Confirmed'])) {
            return redirect()->back()
                ->with('error', 'Hanya booking dengan status Pending atau Confirmed yang dapat dibatalkan.');
        }

        $booking->update(['status' => 'Cancelled']);

        return redirect()->back()
            ->with('success', 'Booking cancelled successfully.');
    }

    // Show payment form
    public function showPaymentForm($slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        if ($booking->status !== 'Pending' && $booking->status !== 'Confirmed') {
            return redirect()->back()
                ->with('error', 'Pembayaran hanya dapat dilakukan untuk booking dengan status Pending atau Confirmed.');
        }

        return view('bookings.payment', compact('booking'));
    }

    // Process payment
    // public function processPayment(Request $request, $slug)
    // {
    //     $booking = Booking::where('slug', $slug)->firstOrFail();

    //     $validator = Validator::make($request->all(), [
    //         'method' => 'required|in:Transfer,Cash',
    //         'amount' => 'required|numeric|min:' . $booking->total_price,
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     // Create payment record
    //     $payment = Payment::create([
    //         'booking_id' => $booking->id,
    //         'slug' => Str::slug(Str::random(10)),
    //         'method' => $request->method,
    //         'status' => $request->method === 'Cash' ? 'Paid' : 'Pending',
    //         'amount' => $request->amount,
    //         'payment_url' => $request->method === 'Transfer' ? 'generated-payment-url' : null,
    //         'payment_date' => $request->method === 'Cash' ? now() : null,
    //     ]);

    //     // Update booking status if paid
    //     if ($request->method === 'Cash') {
    //         $booking->update(['status' => 'Confirmed']);
    //     }

    //     return redirect()->route('bookings.show', $booking->slug)
    //         ->with('success', $request->method === 'Cash'
    //             ? 'Pembayaran tunai berhasil dicatat.'
    //             : 'Silakan selesaikan pembayaran transfer.');
    // }
    public function processPayment(Request $request, $slug)
    {
        $booking = Booking::where('slug', $slug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'method' => 'required|in:Transfer,Cash',
            'amount' => 'required|numeric|min:' . $booking->total_price,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Handle Cash payment
        if ($request->method === 'Cash') {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'slug' => Str::slug(Str::random(10)),
                'method' => $request->method,
                'status' => 'Paid',
                'amount' => $request->amount,
                'payment_date' => now(),
            ]);

            $booking->update(['status' => 'Confirmed']);

            return redirect()->route('bookings.show', $booking->slug)
                ->with('success', 'Pembayaran tunai berhasil dicatat.');
        }

        // Handle Transfer payment (Midtrans)
        try {
            $midtransService = new MidtransService();

            // Generate unique order ID
            $orderId = 'BOOK-' . $booking->id . '-' . time();

            // Prepare transaction details
            $transactionDetails = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $request->amount,
                ],
                'customer_details' => [
                    'first_name' => $booking->name,
                    'email' => $booking->user->email,
                    'phone' => '', // Add phone if available
                ],
                'item_details' => [
                    [
                        'id' => $booking->item_id,
                        'price' => $booking->total_price,
                        'quantity' => 1,
                        'name' => 'Booking #' . $booking->slug,
                    ]
                ],
            ];

            // Create payment record first
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'slug' => Str::slug(Str::random(10)),
                'method' => $request->method,
                'status' => 'Paid',
                'amount' => $request->amount,
                'payment_reference' => $orderId,
                'payment_date' => now(),
            ]);

            $booking->update(['status' => 'Confirmed']);

            // Get Snap payment URL
            $snapToken = $midtransService->createTransaction($transactionDetails);

            // Update payment with the payment URL
            $payment->update([
                'payment_url' => $snapToken->redirect_url
            ]);

            return redirect($snapToken->redirect_url);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
    public function handlePaymentNotification(Request $request)
    {
        try {
            $midtransService = new MidtransService();
            $notification = $midtransService->handleNotification($request);

            // Find payment by order_id (payment_reference)
            $payment = Payment::where('payment_reference', $notification['payment_reference'])
                ->firstOrFail();

            // Update payment status based on notification
            if ($notification['status'] == 'capture' || $notification['status'] == 'settlement') {
                $payment->update([
                    'status' => 'Paid',
                    'payment_date' => now(),
                ]);

                // Update booking status if needed
                $booking = $payment->booking;
                if ($booking->status === 'Pending') {
                    $booking->update(['status' => 'Confirmed']);
                }
            } elseif ($notification['status'] == 'expire') {
                $payment->update(['status' => 'Expired']);
            } elseif ($notification['status'] == 'deny' || $notification['status'] == 'cancel') {
                $payment->update(['status' => 'Failed']);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function paymentReturn(Request $request)
    {
        $orderId = $request->order_id;

        if (!$orderId) {
            return redirect()->route('bookings.index')
                ->with('error', 'Invalid payment return');
        }

        $payment = Payment::where('payment_reference', $orderId)->firstOrFail();
        $booking = $payment->booking;

        if ($payment->status === 'Paid') {
            return redirect()->route('bookings.show', $booking->slug)
                ->with('success', 'Pembayaran berhasil diproses');
        }

        return redirect()->route('bookings.show', $booking->slug)
            ->with('warning', 'Pembayaran sedang diproses');
    }
}
