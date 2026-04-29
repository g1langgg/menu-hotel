<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Order::with(['orderItems.menu', 'orderItems.menu.category'])->latest();
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        $orders = $query->paginate(15);
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'diproses')->count();
        $completedOrders = Order::where('status', 'selesai')->count();
        $todayRevenue = Order::whereDate('created_at', today())->where('status', 'selesai')->sum('total_price');
        
        return view('admin.orders.index', compact(
            'orders', 'totalOrders', 'pendingOrders', 'processingOrders', 'completedOrders', 'todayRevenue'
        ));
    }
    
    public function show($id)
    {
        $order = Order::with(['orderItems.menu', 'orderItems.menu.category'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    
    public function print($id)
    {
        $order = Order::with(['orderItems.menu', 'orderItems.menu.category'])->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai',
            'payment_status' => 'nullable|in:unpaid,verifying,paid'
        ]);
        $order = Order::findOrFail($id);
        
        $updateData = ['status' => $request->status];
        if ($request->has('payment_status')) {
            $updateData['payment_status'] = $request->payment_status;
        }
        
        $order->update($updateData);
        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function dashboardData()
    {
        $pendingOrders = Order::with(['orderItems.menu'])
            ->where('status', 'pending')->latest()->get();
        $serviceRequests = \App\Models\ServiceRequest::where('status', 'pending')
            ->latest()->get();

        return response()->json([
            'pending_count'    => $pendingOrders->count(),
            'service_count'    => $serviceRequests->count(),
            'processing_count' => Order::where('status', 'diproses')->count(),
            'today_revenue'    => Order::where('status', 'selesai')->whereDate('created_at', today())->sum('total_price'),
            'pending_orders'   => $pendingOrders->map(fn($o) => [
                'id'          => $o->id,
                'type'        => $o->type,
                'number'      => $o->number,
                'total_price' => $o->total_price,
                'created_at'  => $o->created_at->diffForHumans(),
                'show_url'    => route('admin.orders.show', $o->id),
            ]),
            'service_requests' => $serviceRequests->map(fn($r) => [
                'id'           => $r->id,
                'type'         => $r->type,
                'number'       => $r->number,
                'request_type' => $r->request_type,
                'created_at'   => $r->created_at->diffForHumans(),
                'resolve_url'  => route('admin.service.request.resolve', $r->id),
            ]),
        ]);
    }
}
