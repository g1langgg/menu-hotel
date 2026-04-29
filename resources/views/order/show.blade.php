<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan #{{ $order->id }} - Amanuba Hotel & Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'bali-cream': '#F5EFE6',
                        'bali-wood': '#8B5E3C',
                        'bali-leaf': '#3A7D44',
                        'bali-orange': '#F97316',
                        'bali-sand': '#F8F4E6',
                        'bali-palm': '#2D5016',
                        'dark-bg': '#0f1117',
                        'dark-card': '#1a1d27'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f1117; color: #e2e8f0; }
        .glass-effect { background: rgba(26, 29, 39, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .btn-gradient { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3); }
        .pulse-dot { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
        .dark-card { background: #1a1d27; border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <!-- Header -->
    <header class="fixed top-0 w-full z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-bali-orange rounded-full flex items-center justify-center shadow-lg text-white">
                        <i class="fas fa-utensils text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">Status Pesanan</h1>
                        <p class="text-xs text-white/40 font-medium tracking-wider uppercase">
                            @if($order->type == 'room')
                                <i class="fas fa-bed mr-1 text-bali-orange"></i>Room {{ $order->number }}
                            @else
                                <i class="fas fa-table mr-1 text-bali-orange"></i>Table {{ $order->number }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu.index') }}" class="btn-gradient text-white px-5 py-2.5 rounded-full font-medium text-sm shadow-md flex items-center">
                        <i class="fas fa-plus mr-2"></i>Pesan Lagi
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pt-28 pb-32">
        @if(session('success'))
            <div class="bg-dark-card border border-teal-500/30 text-teal-400 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-2xl backdrop-blur-sm">
                <div class="w-10 h-10 bg-teal-500/20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <span class="font-bold tracking-wide">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Order Status Card -->
        <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 mb-8 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-32 h-32 bg-bali-orange/5 rounded-full blur-2xl -z-10"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Pesanan <span class="text-bali-orange">#{{ $order->id }}</span>
                    </h2>
                    <p class="text-white/40 font-medium">
                        <i class="fas fa-clock mr-2 text-bali-orange"></i>
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                </div>
                
                <div class="mt-4 md:mt-0 flex flex-col md:items-end space-y-3">
                    @switch($order->status)
                        @case('pending')
                            <div class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-6 py-3 rounded-2xl font-bold flex items-center shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-yellow-500 mr-3 pulse-dot"></span>
                                Menunggu Konfirmasi
                            </div>
                        @break
                        @case('diproses')
                            <div class="bg-blue-50 text-blue-700 border border-blue-200 px-6 py-3 rounded-2xl font-bold flex items-center shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-blue-500 mr-3 pulse-dot"></span>
                                Sedang Diproses
                            </div>
                        @break
                        @case('selesai')
                            <div class="bg-green-50 text-green-700 border border-green-200 px-6 py-3 rounded-2xl font-bold flex items-center shadow-sm">
                                <i class="fas fa-check-circle mr-2 text-green-500 text-lg"></i>
                                Pesanan Selesai
                            </div>
                        @break
                    @endswitch
                    
                    @if($order->payment_method == 'qris')
                        @if($order->payment_status == 'unpaid')
                            <a href="{{ route('order.payment', $order->id) }}" class="bg-bali-orange text-white px-6 py-2 rounded-xl font-bold text-sm text-center shadow-md hover:bg-orange-600 transition">
                                <i class="fas fa-qrcode mr-2"></i>Bayar QRIS Sekarang
                            </a>
                        @elseif($order->payment_status == 'verifying')
                            <div class="bg-blue-50 text-blue-700 border border-blue-200 px-4 py-2 rounded-xl font-bold text-xs flex items-center shadow-sm">
                                <i class="fas fa-search mr-2"></i>Verifikasi Pembayaran
                            </div>
                        @elseif($order->payment_status == 'paid')
                            <div class="bg-green-50 text-green-700 border border-green-200 px-4 py-2 rounded-xl font-bold text-xs flex items-center shadow-sm">
                                <i class="fas fa-check mr-2"></i>Lunas (QRIS)
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 text-gray-700 border border-gray-200 px-4 py-2 rounded-xl font-bold text-xs flex items-center shadow-sm">
                            <i class="fas fa-money-bill-wave mr-2"></i>Bayar di Tempat (Cash)
                        </div>
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="relative px-4">
                <div class="flex justify-between mb-4 relative z-10">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full @if($order->status != 'pending') bg-bali-orange shadow-lg @else bg-bali-orange shadow-lg @endif text-white flex items-center justify-center text-lg font-bold transition-all duration-500 ring-4 ring-dark-bg">
                            @if($order->status != 'pending') <i class="fas fa-check"></i> @else 1 @endif
                        </div>
                        <span class="text-sm font-bold mt-3 @if($order->status != 'pending') text-bali-orange @else text-bali-orange @endif">Dibuat</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full @if($order->status == 'diproses' || $order->status == 'selesai') bg-bali-orange shadow-lg @else bg-white/5 text-white/20 @endif @if($order->status == 'diproses') bg-bali-orange shadow-lg text-white @endif flex items-center justify-center text-lg font-bold transition-all duration-500 ring-4 ring-dark-bg text-white">
                            @if($order->status == 'diproses' || $order->status == 'selesai') <i class="fas fa-check"></i> @else 2 @endif
                        </div>
                        <span class="text-sm font-bold mt-3 @if($order->status == 'diproses' || $order->status == 'selesai') text-bali-orange @else text-white/20 @endif @if($order->status == 'diproses') text-bali-orange @endif">Diproses</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full @if($order->status == 'selesai') bg-bali-orange shadow-lg text-white @else bg-white/5 text-white/20 @endif flex items-center justify-center text-lg font-bold transition-all duration-500 ring-4 ring-dark-bg">
                            @if($order->status == 'selesai') <i class="fas fa-check"></i> @else 3 @endif
                        </div>
                        <span class="text-sm font-bold mt-3 @if($order->status == 'selesai') text-bali-orange @else text-white/20 @endif">Selesai</span>
                    </div>
                </div>
                <div class="absolute top-6 left-10 right-10 h-1.5 bg-white/5 rounded-full"></div>
                <div class="absolute top-6 left-10 h-1.5 rounded-full transition-all duration-1000 ease-in-out bg-bali-orange" 
                     style="width: @if($order->status == 'pending') 0% @elseif($order->status == 'diproses') 50% @else calc(100% - 2.5rem) @endif"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8">
                    <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                        <div class="w-10 h-10 rounded-full bg-bali-orange/10 flex items-center justify-center mr-3">
                            <i class="fas fa-list text-bali-orange"></i>
                        </div>
                        Rincian Item
                    </h3>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center justify-between p-4 border border-white/5 rounded-2xl bg-white/5 hover:border-bali-orange/30 transition">
                                <div class="flex items-center space-x-4">
                                    @if($item->menu->image)
                                        <img src="{{ Storage::url($item->menu->image) }}" 
                                             alt="{{ $item->menu->name }}" 
                                             class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-white/5 rounded-xl flex items-center justify-center text-white/20">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <h4 class="font-bold text-white">{{ $item->menu->name }}</h4>
                                        <p class="text-sm text-white/40 font-medium mt-1">
                                            {{ $item->menu->category->name }} <span class="mx-1 text-white/10">|</span> Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="text-right pl-4">
                                    <p class="text-sm font-bold text-bali-orange bg-bali-orange/10 px-2 py-0.5 rounded-md inline-block mb-1">Qty: {{ $item->quantity }}</p>
                                    <p class="font-bold text-white text-lg">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 sticky top-28">
                    <h3 class="text-xl font-bold mb-6 text-white border-b border-white/5 pb-4">
                        Ringkasan Biaya
                    </h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-white/40 font-medium">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->total_price / 1.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-white/40 font-medium">
                            <span>Pajak (10%)</span>
                            <span>Rp {{ number_format($order->total_price * 0.1 / 1.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-white/5 pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-white">Total Pembayaran</span>
                                <span class="text-2xl font-bold text-bali-orange">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-4 bg-white/5 rounded-2xl flex items-start border border-white/5">
                        <div class="text-bali-orange mt-0.5 mr-3"><i class="fas fa-heart"></i></div>
                        <p class="text-xs text-white/50 font-medium leading-relaxed">
                            Terima kasih telah memesan! Pesanan Anda sedang disiapkan dengan penuh cinta oleh chef kami.
                        </p>
                    </div>

                    <!-- Notes -->
                    @if($order->notes)
                    <div class="mt-6 pt-6 border-t border-white/5">
                        <h3 class="text-sm font-bold tracking-wider text-white/20 uppercase mb-3 flex items-center">
                            <i class="fas fa-comment mr-2"></i>Catatan Khusus
                        </h3>
                        <p class="text-white/70 font-medium bg-white/5 p-4 rounded-2xl italic border border-white/5">
                            "{{ $order->notes }}"
                        </p>
                    </div>
                    @endif

                    <!-- Auto Refresh Info -->
                    <div class="bg-dark-bg border border-bali-orange/20 rounded-2xl p-4 mt-6 flex items-center justify-center shadow-sm">
                        <span class="relative flex h-3 w-3 mr-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-bali-orange opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-bali-orange"></span>
                        </span>
                        <p class="text-xs text-bali-orange font-medium">
                            Halaman diperbarui otomatis (5d)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Polling order status real-time
        function checkOrderStatus() {
            fetch(`/api/order/{{ $order->id }}/status`)
                .then(res => res.json())
                .then(data => {
                    // Current status in the view
                    const currentStatus = '{{ $order->status }}';
                    
                    if(data.status !== currentStatus) {
                        // Status changed! Reload page to show new UI and animations
                        location.reload();
                    }
                })
                .catch(err => console.error('Error polling status:', err));
        }

        // Check every 5 seconds for faster feedback
        setInterval(checkOrderStatus, 5000);
    </script>
</body>
</html>
