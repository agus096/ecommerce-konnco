<?php

namespace App\Http\Controllers;


use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Purchase; // Import model Purchase

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function showPesanan() {
        $pesanan = Purchase::all();
        return view('admin.pesanan', compact(['pesanan']));
    }

    public function createTransaction(Request $request)
    {
        $transaction_details = [
            'order_id' => 'order-' . time(),
            'gross_amount' => $request->amount,
        ];

        $item_details = [
            [
                'id' => $request->product_id,
                'price' => $request->amount,
                'quantity' => 1,
                'name' => $request->product_name,
            ],
        ];

        $customer_details = [
            'first_name' => $request->name,
            'email' => $request->email,
        ];

        $transaction_data = [
            'transaction_details' => $transaction_details,
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        $snapToken = Snap::getSnapToken($transaction_data);

        Purchase::create([
            'order_id' => $transaction_details['order_id'],
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'amount' => $request->amount,
            'qty' => 1,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'status' => 'pending',
        ]);

        return response()->json(['token' => $snapToken]);
    }


    public function handleNotification(Request $request)
    {
        $notification = $request->all();

        Log::info('Received Notification:', $notification);

        if (!isset($notification['order_id'])) {
            Log::error('order_id tidak ada di notifikasi');
            return response()->json(['status' => 'failed', 'message' => 'Missing order_id'], 400);
        }

        $purchase = Purchase::where('order_id', $notification['order_id'])->first();

        if ($purchase) {
            $purchase->status = $notification['transaction_status'];
            $purchase->save();

            Log::info('Update pembayaran berhasil:', $purchase->toArray());

            if ($notification['transaction_status'] == 'settlement') {
                $product = Product::find($purchase->product_id);

                if ($product) {
                    $product->stock -= $purchase->qty;
                    $product->save();
                    Log::info('Update stok berhasil:', $product->toArray());
                } else {
                    Log::error('Produk tidak ada untuk product_id: ' . $purchase->product_id);
                }
            }
        } else {
            Log::error('Pembaryaran tidak ditemukan untuk order_id: ' . $notification['order_id']);
        }

        return response()->json(['status' => 'success']);
    }
}
