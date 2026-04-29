<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }
        
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;
        
        $type = session('qr_type', 'table');
        $number = session('qr_number', '1');
        
        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'total', 'type', 'number'));
    }
    
    public function store(Request $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong!');
        }
        
        $request->validate([
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cash,qris'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Calculate totals
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $tax = $subtotal * 0.1;
            $total = $subtotal + $tax;
            
            // Create order
            $order = Order::create([
                'type' => session('qr_type', 'table'),
                'number' => session('qr_number', '1'),
                'total_price' => $total,
                'status' => 'pending',
                'notes' => $request->notes,
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid'
            ]);
            
            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
            
            // Store order in session for guest tracking
            $guestOrders = session('guest_orders', []);
            $guestOrders[] = $order->id;
            session(['guest_orders' => $guestOrders]);
            
            // Clear cart
            session(['cart' => []]);
            
            DB::commit();
            
            if ($request->payment_method == 'qris') {
                return redirect()->route('order.payment', $order->id);
            }
            
            return redirect()->route('order.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('checkout.index')
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
