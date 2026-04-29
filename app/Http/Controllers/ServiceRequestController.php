<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string|in:call_waiter,bill,clean_table'
        ]);

        $type = session('qr_type', 'table');
        $number = session('qr_number', '1');

        \App\Models\ServiceRequest::create([
            'type' => $type,
            'number' => $number,
            'request_type' => $request->request_type,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Permintaan layanan terkirim!']);
    }

    public function resolve($id)
    {
        $request = \App\Models\ServiceRequest::findOrFail($id);
        $request->update(['status' => 'resolved']);

        return redirect()->back()->with('success', 'Panggilan layanan telah diselesaikan.');
    }
}
