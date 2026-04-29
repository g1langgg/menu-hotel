@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="section-header">
        <div>
            <h1 class="section-title">Dashboard Pesanan</h1>
            <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Kelola semua pesanan masuk</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(148,163,184,0.12);">
                    <i class="fas fa-shopping-cart" style="color:#94a3b8;"></i>
                </div>
                <i class="fas fa-arrow-up text-xs" style="color:rgba(255,255,255,0.3);"></i>
            </div>
            <div class="text-3xl font-bold text-white mb-1">{{ $totalOrders }}</div>
            <div class="text-sm" style="color:rgba(255,255,255,0.4);">Total Pesanan</div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                    <i class="fas fa-hourglass-half text-orange-400"></i>
                </div>
                <span class="badge-pending">Live</span>
            </div>
            <div class="text-3xl font-bold text-white mb-1">{{ $pendingOrders }}</div>
            <div class="text-sm" style="color:rgba(255,255,255,0.4);">Menunggu</div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(59,130,246,0.15);">
                    <i class="fas fa-spinner text-blue-400"></i>
                </div>
                <span class="badge-processing">Proses</span>
            </div>
            <div class="text-3xl font-bold text-white mb-1">{{ $processingOrders }}</div>
            <div class="text-sm" style="color:rgba(255,255,255,0.4);">Diproses</div>
        </div>
        
        <div class="stat-card">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(20,184,166,0.15);">
                    <i class="fas fa-coins text-teal-400"></i>
                </div>
                <span class="badge-completed">Hari Ini</span>
            </div>
            <div class="text-lg font-bold text-white mb-1">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div class="text-sm" style="color:rgba(255,255,255,0.4);">Revenue</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="dark-card p-5">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="dark-label">Status</label>
                <select name="status" class="dark-input" style="appearance:none; cursor:pointer;">
                    <option value="" style="background:#1a1d27;">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} style="background:#1a1d27;">Menunggu</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }} style="background:#1a1d27;">Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }} style="background:#1a1d27;">Selesai</option>
                </select>
            </div>
            
            <div>
                <label class="dark-label">Tipe</label>
                <select name="type" class="dark-input" style="appearance:none; cursor:pointer;">
                    <option value="" style="background:#1a1d27;">Semua Tipe</option>
                    <option value="room" {{ request('type') == 'room' ? 'selected' : '' }} style="background:#1a1d27;">Room Service</option>
                    <option value="table" {{ request('type') == 'table' ? 'selected' : '' }} style="background:#1a1d27;">Dine In</option>
                </select>
            </div>
            
            <div>
                <label class="dark-label">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" class="dark-input" 
                       style="color-scheme: dark;">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="btn-bali-primary w-full justify-center">
                    <i class="fas fa-filter"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="dark-card overflow-hidden">
        <div class="p-5" style="border-bottom:1px solid rgba(255,255,255,0.06);">
            <div class="flex items-center justify-between">
                <h3 class="font-semibold text-white">Semua Pesanan</h3>
                <span class="text-sm" style="color:rgba(255,255,255,0.4);">{{ $orders->total() }} total</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="dark-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipe & Nomor</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td data-label="ID">
                            <span class="font-mono font-bold" style="color:#F97316;">#{{ $order->id }}</span>
                        </td>
                        <td data-label="Tipe & Nomor">
                            <div class="flex items-center space-x-2">
                                <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                                     style="background:{{ $order->type == 'room' ? 'rgba(59,130,246,0.15)' : 'rgba(20,184,166,0.15)' }}">
                                    <i class="fas fa-{{ $order->type == 'room' ? 'bed text-blue-400' : 'table text-teal-400' }} text-xs"></i>
                                </div>
                                <span class="text-white font-medium">{{ ucfirst($order->type) }} {{ $order->number }}</span>
                            </div>
                        </td>
                        <td data-label="Total">
                            <span class="font-semibold" style="color:#14b8a6;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </td>
                        <td data-label="Status">
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge-pending"><i class="fas fa-hourglass-half mr-1"></i>Menunggu</span>
                                @break
                                @case('diproses')
                                    <span class="badge-processing"><i class="fas fa-spinner mr-1"></i>Diproses</span>
                                @break
                                @case('selesai')
                                    <span class="badge-completed"><i class="fas fa-check-circle mr-1"></i>Selesai</span>
                                @break
                                @case('cancelled')
                                    <span class="badge-cancelled"><i class="fas fa-times-circle mr-1"></i>Batal</span>
                                @break
                            @endswitch
                        </td>
                        <td data-label="Waktu" style="color:rgba(255,255,255,0.5);">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td data-label="Aksi">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-all"
                               style="background:rgba(249,115,22,0.15); color:#F97316; border:1px solid rgba(249,115,22,0.3);"
                               onmouseover="this.style.background='rgba(249,115,22,0.25)';"
                               onmouseout="this.style.background='rgba(249,115,22,0.15)';">
                                <i class="fas fa-eye mr-1.5"></i>Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-16">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(255,255,255,0.04);">
                                <i class="fas fa-inbox text-2xl" style="color:rgba(255,255,255,0.2);"></i>
                            </div>
                            <p style="color:rgba(255,255,255,0.4);">Belum ada data pesanan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="p-5" style="border-top:1px solid rgba(255,255,255,0.06);">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
