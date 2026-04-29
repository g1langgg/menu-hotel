<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $guestOrders = session('guest_orders', []);
        $orders = Order::whereIn('id', $guestOrders)
                    ->with(['orderItems.menu'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                    
        return view('order.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['orderItems.menu', 'orderItems.menu.category'])->findOrFail($id);
        return view('order.show', compact('order'));
    }
    
    public function search(Request $request)
    {
        $request->validate(['order_id' => 'required|string']);
        $order = Order::with(['orderItems.menu', 'orderItems.menu.category'])
                    ->where('id', $request->order_id)->first();
        if (!$order) return back()->with('error', 'Pesanan tidak ditemukan!');
        return view('order.show', compact('order'));
    }

    public function status($id)
    {
        $order = Order::findOrFail($id);
        return response()->json([
            'status'     => $order->status,
            'updated_at' => $order->updated_at->diffForHumans(),
        ]);
    }

    public function payment($id)
    {
        $order = Order::findOrFail($id);
        
        // If not QRIS or already paid/verifying, just redirect to show
        if ($order->payment_method != 'qris' || $order->payment_status != 'unpaid') {
            return redirect()->route('order.show', $order->id);
        }
        
        // Get the base QRIS from settings
        $baseQris = \App\Models\Setting::get('qris_base_string');
        $dynamicQris = null;
        
        if ($baseQris) {
            $dynamicQris = \App\Services\QrisService::generateDynamic($baseQris, $order->total_price);
        }

        $qrisImage = \App\Models\Setting::get('qris_image');
        
        return view('order.payment', compact('order', 'dynamicQris', 'qrisImage'));
    }

    public function uploadReceipt(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);
        
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $filename = time() . '_receipt.' . $file->getClientOriginalExtension();
            $file->storeAs('receipts', $filename, 'public');
            
            $order->update([
                'payment_receipt' => 'receipts/' . $filename,
                'payment_status' => 'verifying'
            ]);
        }
        
        return redirect()->route('order.show', $order->id)
            ->with('success', 'Bukti transfer berhasil diunggah. Kami akan segera memverifikasi pembayaran Anda.');
    }
}
