<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Amanuba Hotel & Resort</title>
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
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #0f1117; color: #e2e8f0; }
        .glass-effect { background: rgba(26, 29, 39, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .btn-gradient { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <!-- Header -->
    <header class="fixed top-0 w-full z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('menu.index') }}" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center text-white shadow-sm border border-white/5 hover:bg-white/10 transition">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h1 class="text-xl font-bold text-white">Pesanan Saya</h1>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 pt-24 pb-12">
        @if($orders->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 bg-dark-card rounded-full flex items-center justify-center shadow-lg mb-6 border border-white/5">
                    <i class="fas fa-receipt text-white/10 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Belum ada pesanan</h2>
                <p class="text-white/40 mb-8 max-w-xs">Anda belum melakukan pemesanan apapun dalam sesi ini.</p>
                <a href="{{ route('menu.index') }}" class="btn-gradient text-white px-8 py-3 rounded-2xl font-bold shadow-lg">
                    Lihat Menu
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <a href="{{ route('order.show', $order->id) }}" class="block bg-dark-card rounded-3xl p-6 shadow-sm border border-white/5 hover:border-bali-orange/30 transition-all group">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs font-bold text-bali-orange uppercase tracking-wider mb-1">#{{ $order->id }}</p>
                                <h3 class="text-lg font-bold text-white">{{ $order->created_at->format('d M Y, H:i') }}</h3>
                            </div>
                            <div class="px-3 py-1 rounded-full text-xs font-bold 
                                @if($order->status == 'pending') bg-orange-500/10 text-orange-500 border border-orange-500/20
                                @elseif($order->status == 'diproses') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                @else bg-teal-500/10 text-teal-400 border border-teal-500/20 @endif">
                                {{ ucfirst($order->status) }}
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2 mb-4 overflow-x-auto pb-2">
                            @foreach($order->orderItems->take(3) as $item)
                                <div class="flex-shrink-0 w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center overflow-hidden border border-white/5">
                                    @if($item->menu->image)
                                        <img src="{{ Storage::url($item->menu->image) }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-utensils text-white/10"></i>
                                    @endif
                                </div>
                            @endforeach
                            @if($order->orderItems->count() > 3)
                                <div class="flex-shrink-0 w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center text-xs font-bold text-white/20">
                                    +{{ $order->orderItems->count() - 3 }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-white/5">
                            <span class="text-sm text-white/40">{{ $order->orderItems->count() }} Item</span>
                            <div class="flex items-center font-bold text-white">
                                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                <i class="fas fa-chevron-right ml-3 text-bali-orange group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>
