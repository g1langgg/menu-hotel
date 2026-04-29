<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Amanuba Hotel & Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .dark-card { background: #1a1d27; border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <!-- Header -->
    <header class="fixed top-0 w-full z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-white leading-tight">KERANJANG</h1>
                        <p class="text-[10px] text-white/40 font-medium tracking-widest uppercase leading-none">
                            @if(session('qr_type') == 'room')
                                <i class="fas fa-bed mr-1 text-bali-orange"></i>Room {{ session('qr_number') }}
                            @else
                                <i class="fas fa-table mr-1 text-bali-orange"></i>Table {{ session('qr_number') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('menu.index') }}" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center shadow-sm text-white hover:bg-white/10 transition border border-white/5">
                        <i class="fas fa-arrow-left"></i>
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

        @if(empty($cart))
            <div class="text-center py-16 bg-dark-card rounded-3xl shadow-sm border border-white/5 mt-8">
                <i class="fas fa-shopping-cart text-white/10 text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-white mb-2">Keranjang Kosong</h2>
                <p class="text-white/40 mb-8 max-w-md mx-auto">Belum ada menu yang ditambahkan. Silakan lihat menu kami dan temukan sajian istimewa Anda.</p>
                <a href="{{ route('menu.index') }}" 
                   class="btn-gradient text-white px-8 py-3.5 rounded-full font-bold shadow-md inline-flex items-center">
                    <i class="fas fa-utensils mr-2"></i>Lihat Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8">
                        <h2 class="text-xl font-bold mb-6 text-white flex items-center">
                            <div class="w-10 h-10 rounded-full bg-bali-orange/10 flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-bali-orange"></i>
                            </div>
                            Pesanan Anda
                        </h2>
                        
                        <div class="space-y-4" id="cartItems">
                            @foreach($cart as $key => $item)
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
                                            <p class="text-sm font-bold text-bali-orange mt-1">
                                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center space-x-2 bg-white/5 rounded-xl p-1 border border-white/5">
                                            <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" 
                                                    class="w-8 h-8 rounded-lg bg-dark-card shadow-sm text-white/60 hover:text-bali-orange transition"
                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus text-xs"></i>
                                            </button>
                                            <input type="number" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   class="w-10 text-center bg-transparent font-bold text-white border-none focus:ring-0"
                                                   onchange="updateQuantity({{ $item['id'] }}, this.value)">
                                            <button onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})" 
                                                    class="w-8 h-8 rounded-lg bg-dark-card shadow-sm text-white/60 hover:text-bali-orange transition">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="text-right w-24 hidden sm:block">
                                            <p class="font-bold text-white">
                                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        
                                        <button onclick="removeFromCart({{ $item['id'] }})" 
                                                class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition flex items-center justify-center">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-8 flex justify-between items-center pt-6 border-t border-white/5">
                            <button onclick="clearCart()" 
                                    class="text-red-500 hover:text-red-400 font-semibold text-sm flex items-center transition">
                                <i class="fas fa-trash-alt mr-2"></i>Kosongkan
                            </button>
                            <a href="{{ route('menu.index') }}" 
                               class="text-white/60 hover:text-bali-orange font-semibold text-sm flex items-center transition">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Menu Lain
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-dark-card rounded-3xl shadow-sm border border-white/5 p-8 sticky top-28 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-bali-orange/5 rounded-full blur-2xl -z-10"></div>
                        <h2 class="text-xl font-bold mb-6 text-white border-b border-white/5 pb-4">Ringkasan</h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-white/40 font-medium">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-white/40 font-medium">
                                <span>Pajak (10%)</span>
                                <span>Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-white/5 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">Total</span>
                                    <span class="text-2xl font-bold text-bali-orange">
                                        Rp {{ number_format($total * 1.1, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" 
                           class="w-full btn-gradient text-white px-6 py-4 rounded-2xl font-bold text-lg flex items-center justify-center">
                            Checkout Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        
                        <div class="mt-6 flex items-start p-4 bg-white/5 rounded-2xl border border-white/5">
                            <div class="text-bali-orange mt-0.5 mr-3"><i class="fas fa-shield-alt"></i></div>
                            <p class="text-xs text-white/50 font-medium leading-relaxed">
                                Anda dapat mengkonfirmasi pesanan dan menambahkan catatan di halaman selanjutnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-10 right-10 z-[100] bg-dark-card text-white px-6 py-4 rounded-2xl shadow-2xl border border-bali-orange/30 transform translate-y-[200%] transition-all duration-500 flex items-center space-x-3 backdrop-blur-xl bg-opacity-95">
        <div class="w-8 h-8 bg-bali-orange/20 rounded-full flex items-center justify-center text-bali-orange">
            <i class="fas fa-check"></i>
        </div>
        <span id="toastMessage" class="font-bold text-sm">Berhasil!</span>
    </div>

    <script>
        // Update quantity
        function updateQuantity(menuId, quantity) {
            if (quantity < 1) return;
            
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); 
                }
            });
        }

        // Remove from cart
        function removeFromCart(menuId) {
            if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        menu_id: menuId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        // Clear cart
        function clearCart() {
            if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                window.location.href = '/cart/clear';
            }
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toastMessage.textContent = message;
            toast.classList.remove('translate-y-[200%]', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
            
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[200%]', 'opacity-0');
            }, 3000);
        }
    </script>
</body>
</html>
