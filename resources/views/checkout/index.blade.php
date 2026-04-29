<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Amanuba Hotel & Resort</title>
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
        .btn-outline { transition: all 0.3s ease; border: 2px solid rgba(255, 255, 255, 0.05); }
        .btn-outline:hover { border-color: #F97316; color: #F97316; background: transparent; }
        .dark-card { background: #1a1d27; border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <!-- Header -->
    <header class="fixed top-0 w-full z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('cart.index') }}" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center shadow-sm text-white hover:bg-white/10 transition border border-white/5">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-white">Checkout</h1>
                        <p class="text-xs text-white/40 font-medium tracking-wider uppercase">
                            @if($type == 'room')
                                <i class="fas fa-bed mr-1 text-bali-orange"></i>Room {{ $number }}
                            @else
                                <i class="fas fa-table mr-1 text-bali-orange"></i>Table {{ $number }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pt-28 pb-32">
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Delivery Information -->
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-bali-orange/5 rounded-full blur-2xl -z-10"></div>
                        <h2 class="text-xl font-bold mb-6 text-white flex items-center">
                            <div class="w-10 h-10 rounded-full bg-bali-orange/10 flex items-center justify-center mr-3">
                                <i class="fas fa-location-dot text-bali-orange"></i>
                            </div>
                            Informasi Pengiriman
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold tracking-wider text-white/20 uppercase mb-2">Tipe Pesanan</label>
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/5 font-medium text-white/60 flex items-center">
                                    @if($type == 'room')
                                        <div class="w-8 h-8 rounded-full bg-dark-card shadow-sm flex items-center justify-center mr-3"><i class="fas fa-bed text-bali-orange"></i></div> Room Service
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-dark-card shadow-sm flex items-center justify-center mr-3"><i class="fas fa-table text-bali-orange"></i></div> Dine In
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold tracking-wider text-white/20 uppercase mb-2">Nomor</label>
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/5 font-medium text-white/60 flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-dark-card shadow-sm flex items-center justify-center mr-3 text-bali-orange font-bold">#</div>
                                    {{ $number }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 relative overflow-hidden">
                        <h2 class="text-xl font-bold mb-6 text-white flex items-center">
                            <div class="w-10 h-10 rounded-full bg-bali-orange/10 flex items-center justify-center mr-3">
                                <i class="fas fa-list text-bali-orange"></i>
                            </div>
                            Detail Pesanan
                        </h2>
                        
                        <div class="space-y-4">
                            @foreach($cart as $item)
                                <div class="flex items-center justify-between p-4 border border-white/5 rounded-2xl hover:border-bali-orange/30 transition-colors bg-white/5">
                                    <div class="flex items-center space-x-4">
                                        @if($item['image'])
                                            <img src="{{ Storage::url($item['image']) }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-white/5 rounded-xl flex items-center justify-center text-white/20">
                                                <i class="fas fa-image text-2xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <h3 class="font-bold text-white">{{ $item['name'] }}</h3>
                                            <p class="text-sm text-white/40 font-medium mt-1">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }} <span class="mx-1 text-white/10">|</span> <span class="text-bali-orange bg-bali-orange/10 px-2 py-0.5 rounded-md">Qty: {{ $item['quantity'] }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right pl-4">
                                        <p class="font-bold text-white text-lg">
                                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 relative overflow-hidden">
                        <h2 class="text-xl font-bold mb-6 text-white flex items-center">
                            <div class="w-10 h-10 rounded-full bg-bali-orange/10 flex items-center justify-center mr-3">
                                <i class="fas fa-wallet text-bali-orange"></i>
                            </div>
                            Metode Pembayaran
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer rounded-2xl border border-white/5 bg-white/5 p-5 shadow-sm focus:outline-none transition-all has-[:checked]:border-bali-orange has-[:checked]:bg-bali-orange/5">
                                <input type="radio" name="payment_method" value="qris" class="sr-only" checked>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-white mb-1"><i class="fas fa-qrcode mr-2 text-bali-orange"></i>Bayar Pakai QRIS</span>
                                        <span class="mt-1 flex items-center text-xs text-white/40">Scan langsung dari m-BCA, Gopay, OVO, Dana, dll.</span>
                                    </span>
                                </span>
                                <i class="fas fa-check-circle text-bali-orange text-xl absolute top-5 right-5 hidden check-icon"></i>
                            </label>

                            <label class="relative flex cursor-pointer rounded-2xl border border-white/5 bg-white/5 p-5 shadow-sm focus:outline-none transition-all has-[:checked]:border-bali-orange has-[:checked]:bg-bali-orange/5">
                                <input type="radio" name="payment_method" value="cash" class="sr-only">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-bold text-white mb-1"><i class="fas fa-money-bill-wave mr-2 text-teal-400"></i>Bayar di Tempat (Cash)</span>
                                        <span class="mt-1 flex items-center text-xs text-white/40">Bayar ke staff kami saat pesanan diantar.</span>
                                    </span>
                                </span>
                                <i class="fas fa-check-circle text-bali-orange text-xl absolute top-5 right-5 hidden check-icon"></i>
                            </label>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 relative overflow-hidden">
                        <h2 class="text-xl font-bold mb-6 text-white flex items-center">
                            <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center mr-3">
                                <i class="fas fa-comment text-white/40"></i>
                            </div>
                            Catatan Tambahan
                        </h2>
                        
                        <textarea name="notes" 
                                  rows="3" 
                                  class="w-full border-white/10 bg-white/5 rounded-2xl px-5 py-4 text-white focus:outline-none focus:ring-2 focus:ring-bali-orange focus:bg-white/10 transition-all resize-none shadow-inner"
                                  placeholder="Tuliskan permintaan khusus Anda di sini... (opsional)">{{ old('notes') }}</textarea>
                        <p class="text-xs text-white/20 mt-2 font-medium ml-2"><i class="fas fa-info-circle mr-1"></i>Maksimal 500 karakter</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 sticky top-28">
                        <h2 class="text-xl font-bold mb-6 text-white border-b border-white/5 pb-4">Ringkasan Biaya</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-white/40 font-medium">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-white/40 font-medium">
                                <span>Pajak (10%)</span>
                                <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-white/5 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">Total Pembayaran</span>
                                    <span class="text-2xl font-bold text-bali-orange">
                                        Rp {{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <button type="submit" class="w-full btn-gradient text-white px-6 py-4 rounded-2xl font-bold text-lg flex items-center justify-center">
                                Pesan Sekarang <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="w-full btn-outline text-white/60 px-6 py-4 rounded-2xl font-semibold text-center block bg-white/5">
                                Kembali ke Keranjang
                            </a>
                        </div>
                        
                        <div class="mt-6 flex items-start p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div class="text-bali-orange mt-0.5 mr-3"><i class="fas fa-shield-alt"></i></div>
                            <p class="text-xs text-white/50 font-medium leading-relaxed">
                                Pembayaran dapat dilakukan setelah pesanan diantar (Pay at Table/Room) atau dibebankan pada tagihan kamar Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
