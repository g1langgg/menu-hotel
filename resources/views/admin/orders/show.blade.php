@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="section-header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.orders.index') }}" class="btn-bali-secondary px-3 py-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="section-title">Detail Pesanan <span style="color:#F97316;">#{{ $order->id }}</span></h1>
                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn-bali-secondary">
                <i class="fas fa-print"></i>Cetak Bill
            </a>

            <!-- Status Badge -->
            @switch($order->status)
                @case('pending')
                    <span class="badge-pending text-sm px-4 py-2"><i class="fas fa-hourglass-half mr-2"></i>Menunggu Konfirmasi</span>
                @break
                @case('diproses')
                    <span class="badge-processing text-sm px-4 py-2"><i class="fas fa-fire mr-2"></i>Sedang Diproses</span>
                @break
                @case('selesai')
                    <span class="badge-completed text-sm px-4 py-2"><i class="fas fa-check-circle mr-2"></i>Pesanan Selesai</span>
                @break
                @case('cancelled')
                    <span class="badge-cancelled text-sm px-4 py-2"><i class="fas fa-times-circle mr-2"></i>Dibatalkan</span>
                @break
            @endswitch
        </div>
    </div>

    <!-- Status Update -->
    @if($order->status != 'selesai' && $order->status != 'cancelled')
    <div class="dark-card p-5">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                <i class="fas fa-edit text-orange-400 text-sm"></i>
            </div>
            <h3 class="font-semibold text-white">Update Status Pesanan</h3>
        </div>
        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="flex items-center space-x-3 flex-wrap gap-3">
                <select name="status" class="dark-input" style="max-width:220px; appearance:none; cursor:pointer;">
                    @if($order->status == 'pending')
                        <option value="pending" selected style="background:#1a1d27;">⏳ Menunggu</option>
                        <option value="diproses" style="background:#1a1d27;">🔥 Diproses</option>
                        <option value="selesai" style="background:#1a1d27;">✅ Selesai</option>
                    @elseif($order->status == 'diproses')
                        <option value="pending" style="background:#1a1d27;">⏳ Menunggu</option>
                        <option value="diproses" selected style="background:#1a1d27;">🔥 Diproses</option>
                        <option value="selesai" style="background:#1a1d27;">✅ Selesai</option>
                    @endif
                </select>
                <button type="submit" class="btn-bali-primary">
                    <i class="fas fa-save"></i>Update Status
                </button>
            </div>
        </form>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Items - Left -->
        <div class="lg:col-span-2 space-y-4">
            <div class="dark-card p-6">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-list text-orange-400"></i>
                    </div>
                    <h3 class="font-semibold text-white text-lg">Item Pesanan</h3>
                    <span class="badge-pending">{{ $order->orderItems->count() }} item</span>
                </div>
                
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between p-4 rounded-xl transition-colors"
                         style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);"
                         onmouseover="this.style.background='rgba(255,255,255,0.05)';"
                         onmouseout="this.style.background='rgba(255,255,255,0.03)';">
                        <div class="flex items-center space-x-4">
                            @if($item->menu->image)
                                <img src="{{ Storage::url($item->menu->image) }}" 
                                     alt="{{ $item->menu->name }}" 
                                     class="w-14 h-14 rounded-xl object-cover"
                                     style="border:1px solid rgba(255,255,255,0.08);">
                            @else
                                <div class="w-14 h-14 rounded-xl flex items-center justify-center"
                                     style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08);">
                                    <i class="fas fa-utensils" style="color:rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                            
                            <div>
                                <h4 class="font-semibold text-white">{{ $item->menu->name }}</h4>
                                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">
                                    {{ $item->menu->category->name }} &bull; Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="text-right">
                            <div class="inline-flex items-center px-3 py-1 rounded-lg mb-1" style="background:rgba(249,115,22,0.1);">
                                <span class="text-sm font-bold" style="color:#F97316;">x{{ $item->quantity }}</span>
                            </div>
                            <p class="font-bold text-white">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Notes -->
            @if($order->notes)
            <div class="dark-card p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-comment text-orange-400"></i>
                    </div>
                    <h3 class="font-semibold text-white">Catatan Pesanan</h3>
                </div>
                <div class="p-4 rounded-xl" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                    <p style="color:rgba(255,255,255,0.7); line-height:1.6;">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-4">
            <!-- Payment Summary -->
            <div class="dark-card p-6">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(20,184,166,0.15);">
                        <i class="fas fa-receipt text-teal-400"></i>
                    </div>
                    <h3 class="font-semibold text-white">Ringkasan</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm" style="color:rgba(255,255,255,0.5);">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_price / 1.1, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm" style="color:rgba(255,255,255,0.5);">
                        <span>Pajak (10%)</span>
                        <span>Rp {{ number_format($order->total_price * 0.1 / 1.1, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-3" style="border-top:1px solid rgba(255,255,255,0.08);">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-white">Total</span>
                            <span class="text-xl font-bold" style="color:#14b8a6;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($order->status == 'selesai')
                <div class="mt-4 p-3 rounded-xl" style="background:rgba(20,184,166,0.1); border:1px solid rgba(20,184,166,0.2);">
                    <p class="text-sm flex items-center" style="color:#14b8a6;">
                        <i class="fas fa-check-circle mr-2"></i>Pesanan telah selesai & dibayar
                    </p>
                </div>
                @endif
            </div>

            <!-- Payment Info & Receipt -->
            <div class="dark-card p-6">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(59,130,246,0.15);">
                        <i class="fas fa-wallet text-blue-400"></i>
                    </div>
                    <h3 class="font-semibold text-white">Informasi Pembayaran</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm items-center">
                        <span style="color:rgba(255,255,255,0.5);">Metode</span>
                        <span class="font-semibold text-white">{{ strtoupper($order->payment_method) }}</span>
                    </div>
                    <div class="flex justify-between text-sm items-center pb-3" style="border-bottom:1px solid rgba(255,255,255,0.08);">
                        <span style="color:rgba(255,255,255,0.5);">Status Pembayaran</span>
                        @if($order->payment_status == 'paid')
                            <span class="text-teal-400 font-bold"><i class="fas fa-check-circle mr-1"></i>Lunas</span>
                        @elseif($order->payment_status == 'verifying')
                            <span class="text-yellow-400 font-bold"><i class="fas fa-search mr-1"></i>Verifikasi</span>
                        @else
                            <span class="text-red-400 font-bold"><i class="fas fa-times-circle mr-1"></i>Belum Bayar</span>
                        @endif
                    </div>
                    
                    @if($order->payment_method == 'qris' && $order->payment_receipt)
                        <div class="pt-2">
                            <p class="text-xs mb-2" style="color:rgba(255,255,255,0.5);">Bukti Transfer (Klik untuk memperbesar)</p>
                            <a href="{{ Storage::url($order->payment_receipt) }}" target="_blank" class="block w-full">
                                <img src="{{ Storage::url($order->payment_receipt) }}" alt="Bukti Transfer" class="w-full h-32 object-cover rounded-xl" style="border:1px solid rgba(255,255,255,0.1);">
                            </a>
                        </div>
                    @endif
                    
                    @if($order->payment_method == 'qris' && $order->payment_status == 'verifying')
                        <div class="pt-4">
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="diproses">
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" class="w-full btn-bali-primary py-2.5 flex justify-center items-center">
                                    <i class="fas fa-check mr-2"></i>Verifikasi Pembayaran
                                </button>
                            </form>
                            <p class="text-xs text-center mt-2" style="color:rgba(255,255,255,0.4);">Akan otomatis mengubah status pesanan ke 'Diproses'</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Info -->
            <div class="dark-card p-6">
                <div class="flex items-center space-x-3 mb-5">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(59,130,246,0.15);">
                        <i class="fas fa-map-marker-alt text-blue-400"></i>
                    </div>
                    <h3 class="font-semibold text-white">Informasi Lokasi</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 rounded-xl" style="background:rgba(255,255,255,0.03);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                             style="background:{{ $order->type == 'room' ? 'rgba(59,130,246,0.15)' : 'rgba(20,184,166,0.15)' }}">
                            <i class="fas fa-{{ $order->type == 'room' ? 'bed text-blue-400' : 'table text-teal-400' }} text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs" style="color:rgba(255,255,255,0.4);">Tipe</p>
                            <p class="font-semibold text-white text-sm">{{ $order->type == 'room' ? 'Room Service' : 'Dine In' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl" style="background:rgba(255,255,255,0.03);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                            <i class="fas fa-hashtag text-orange-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs" style="color:rgba(255,255,255,0.4);">Nomor</p>
                            <p class="font-semibold text-white text-sm">{{ $order->number }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 p-3 rounded-xl" style="background:rgba(255,255,255,0.03);">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(148,163,184,0.1);">
                            <i class="fas fa-clock" style="color:rgba(255,255,255,0.4); font-size:0.75rem;"></i>
                        </div>
                        <div>
                            <p class="text-xs" style="color:rgba(255,255,255,0.4);">Waktu Pesan</p>
                            <p class="font-semibold text-white text-sm">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
