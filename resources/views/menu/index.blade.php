<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Amanuba Hotel & Resort</title>
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
                        'dark-card': '#1a1d27',
                        'accent-teal': '#14b8a6'
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
        .premium-card { background: #1a1d27; border: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .premium-card:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border-color: rgba(249, 115, 22, 0.4); }
        .btn-gradient { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3); }
        .category-btn-active { background: #F97316; color: white; box-shadow: 0 10px 20px rgba(249, 115, 22, 0.2); }
        .category-btn-inactive { background: rgba(255, 255, 255, 0.05); color: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <!-- Welcome Modal -->
    @if(session('show_welcome'))
        <div id="welcomeModal" class="fixed inset-0 z-[60] flex items-center justify-center p-6 bg-dark-bg/60 backdrop-blur-md">
            <div class="bg-dark-card rounded-[2.5rem] w-full max-w-md overflow-hidden shadow-2xl transform transition-all scale-100 opacity-100 border border-white/10">
                <div class="relative h-48 bg-bali-orange flex items-center justify-center">
                    <div class="absolute inset-0 opacity-40">
                        <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?auto=format&fit=crop&w=600&q=80" class="w-full h-full object-cover" alt="Welcome">
                    </div>
                    <div class="relative w-24 h-24 bg-dark-card rounded-full flex items-center justify-center shadow-xl border-4 border-white/5 overflow-hidden p-2">
                        <img src="{{ asset('img/logo.png') }}" alt="Amanuba Logo" class="w-full h-auto">
                    </div>
                </div>
                <div class="p-8 text-center">
                    <h3 class="text-2xl font-bold text-white mb-2">Selamat Datang!</h3>
                    <p class="text-white/40 mb-6">
                        Anda berada di <span class="font-bold text-bali-orange">{{ $type == 'room' ? 'Kamar' : 'Meja' }} {{ $number }}</span>. 
                        Silakan pilih menu favorit Anda.
                    </p>
                    <button onclick="closeWelcomeModal()" class="w-full btn-gradient text-white py-4 rounded-2xl font-bold text-lg shadow-lg">
                        Lihat Menu
                    </button>
                </div>
            </div>
        </div>
        @php session()->forget('show_welcome'); @endphp
    @endif
    <!-- Header -->
    <header class="fixed top-0 w-full z-40 glass-effect">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h1 class="text-lg font-bold text-white leading-tight">AMANUBA</h1>
                        <p class="text-[10px] text-white/40 font-medium tracking-widest uppercase leading-none">
                            @if($type == 'room')
                                <i class="fas fa-bed mr-1 text-bali-orange"></i>Room {{ $number }}
                            @else
                                <i class="fas fa-table mr-1 text-bali-orange"></i>Table {{ $number }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('order.index') }}" class="w-10 h-10 bg-white/5 rounded-full flex items-center justify-center text-white shadow-sm border border-white/5 hover:bg-white/10 transition-colors">
                        <i class="fas fa-history"></i>
                    </a>
                    <a href="{{ route('cart.index') }}" class="relative btn-gradient text-white px-5 py-2.5 rounded-full font-medium flex items-center">
                        <i class="fas fa-shopping-bag mr-2"></i>Cart
                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 border-2 border-white text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold shadow-md">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pt-28 pb-32">
        <!-- Error Messages -->
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-2xl mb-8 flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Welcome Banner -->
        <div class="bg-dark-card rounded-3xl p-8 mb-10 shadow-sm border border-white/5 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-bali-orange/5 rounded-full blur-3xl -z-10"></div>
            <div class="absolute left-10 bottom-0 w-48 h-48 bg-bali-orange/5 rounded-full blur-3xl -z-10"></div>
            
            <div>
                <h2 class="text-3xl font-bold text-white mb-2">Discover Our Culinary Delights</h2>
                <p class="text-white/50 max-w-xl">Nikmati sajian istimewa yang disiapkan khusus oleh chef terbaik kami, langsung diantarkan ke tempat Anda.</p>
            </div>
            <div class="hidden md:block">
                <img src="https://images.unsplash.com/photo-1544148103-0773bf10d330?auto=format&fit=crop&w=150&q=80" alt="Culinary" class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white/10">
            </div>
        </div>

        <!-- Category Filter -->
        <div class="mb-10 overflow-x-auto pb-4 hide-scrollbar">
            <div class="flex gap-3">
                <button onclick="filterByCategory('all')" 
                        class="category-btn px-6 py-2.5 rounded-full category-btn-active font-medium transition-all whitespace-nowrap">
                    Semua Menu
                </button>
                @foreach($categories as $category)
                    <button onclick="filterByCategory('{{ $category->id }}')" 
                            class="category-btn px-6 py-2.5 rounded-full category-btn-inactive font-medium transition-all whitespace-nowrap shadow-sm hover:border-bali-orange/50 hover:text-bali-orange">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" id="menuGrid">
            @foreach($menus as $menu)
                <div class="menu-item premium-card bg-dark-card rounded-3xl overflow-hidden border border-white/5 group relative" 
                     data-category="{{ $menu->category_id }}">
                    
                    <div class="relative overflow-hidden h-56">
                        @if($menu->image)
                            <img src="{{ Storage::url($menu->image) }}" 
                                 alt="{{ $menu->name }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-white/5 flex items-center justify-center">
                                <i class="fas fa-utensils text-white/20 text-5xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-dark-card/90 backdrop-blur-sm text-white font-medium px-3 py-1 rounded-full text-xs shadow-sm border border-white/5">
                                {{ $menu->category->name }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-white mb-2 leading-tight">{{ $menu->name }}</h3>
                        @if($menu->description)
                            <p class="text-white/40 text-sm mb-6 line-clamp-2">{{ $menu->description }}</p>
                        @else
                            <div class="h-10 mb-6"></div>
                        @endif
                        
                        <div class="flex justify-between items-center mt-auto">
                            <span class="text-xl font-bold text-bali-orange">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </span>
                            <button onclick="addToCart(this, {{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }})" 
                                    class="w-10 h-10 rounded-full bg-white/5 text-bali-orange hover:bg-bali-orange hover:text-white flex items-center justify-center transition-all shadow-sm active:scale-90 border border-white/5">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($menus->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-utensils text-gray-300 text-6xl mb-4"></i>
                <p class="text-gray-500 text-lg">Belum ada menu tersedia</p>
            </div>
        @endif

        <!-- Floating Cart (Mobile) -->
        @if(session('cart') && count(session('cart')) > 0)
            <div class="fixed bottom-28 left-6 right-6 z-50 md:hidden">
                <a href="{{ route('cart.index') }}" class="btn-gradient text-white w-full py-4 rounded-2xl shadow-2xl flex items-center justify-between px-6 transform active:scale-95 transition-transform">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div>
                            <p class="text-xs font-medium opacity-80">Keranjang</p>
                            <p class="font-bold">{{ count(session('cart')) }} Item</p>
                        </div>
                    </div>
                    <div class="flex items-center font-bold">
                        <span>Lihat</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </a>
            </div>
        @endif
    </main>

    <!-- FAB - Call Waiter -->
    <div class="fixed bottom-8 right-6 z-50 flex flex-col gap-3 items-end">
        <!-- Call Waiter Option -->
        <button onclick="requestService('call_waiter')" class="bg-dark-card text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-white/10 hover:scale-110 transition-transform hidden service-option group border border-white/5">
            <i class="fas fa-bell text-lg"></i>
            <span class="absolute right-16 bg-dark-card text-white font-medium text-xs px-3 py-2 rounded-xl shadow-md opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity border border-white/5">Panggil Pelayan</span>
        </button>
        <!-- Request Bill -->
        <button onclick="requestService('bill')" class="bg-dark-card text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-white/10 hover:scale-110 transition-transform hidden service-option group border border-white/5">
            <i class="fas fa-file-invoice-dollar text-lg"></i>
            <span class="absolute right-16 bg-dark-card text-white font-medium text-xs px-3 py-2 rounded-xl shadow-md opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity border border-white/5">Minta Bill</span>
        </button>
        <!-- Clean Table -->
        <button onclick="requestService('clean_table')" class="bg-dark-card text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-white/10 hover:scale-110 transition-transform hidden service-option group border border-white/5">
            <i class="fas fa-broom text-lg"></i>
            <span class="absolute right-16 bg-dark-card text-white font-medium text-xs px-3 py-2 rounded-xl shadow-md opacity-0 group-hover:opacity-100 whitespace-nowrap transition-opacity border border-white/5">Bersihkan Meja</span>
        </button>
        <!-- Call Waiter Main -->
        <button onclick="toggleServiceOptions()" class="btn-gradient text-white w-16 h-16 rounded-full shadow-2xl flex items-center justify-center hover:scale-105 transition-all focus:outline-none pulse-animation mt-2">
            <i class="fas fa-concierge-bell text-2xl"></i>
        </button>
    </div>
    
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes pulse-ring { 0% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(249, 115, 22, 0); } 100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); } }
        .pulse-animation { animation: pulse-ring 2s infinite; }
    </style>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-10 right-10 z-[100] bg-dark-card text-white px-6 py-4 rounded-2xl shadow-2xl border border-bali-orange/30 transform translate-y-[200%] transition-all duration-500 flex items-center space-x-3 backdrop-blur-xl bg-opacity-95">
        <div class="w-8 h-8 bg-bali-orange/20 rounded-full flex items-center justify-center text-bali-orange">
            <i class="fas fa-check"></i>
        </div>
        <span id="toastMessage" class="font-bold text-sm">Berhasil ditambahkan ke keranjang!</span>
    </div>

    <script>
        // Filter by category
        function filterByCategory(categoryId) {
            const buttons = document.querySelectorAll('.category-btn');
            buttons.forEach(btn => {
                btn.classList.remove('category-btn-active');
                btn.classList.add('category-btn-inactive');
            });
            
            event.target.classList.remove('category-btn-inactive');
            event.target.classList.add('category-btn-active');
            
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                if (categoryId === 'all' || item.dataset.category === categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Add to cart
        function addToCart(btn, menuId, menuName, price) {
            // Animation feedback
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            btn.disabled = true;

            // Update cart via AJAX
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.remove('bg-white/5', 'text-bali-orange');
                btn.classList.add('bg-bali-orange', 'text-white');
                
                showToast(data.message);
                
                // Reload after a delay to show floating cart if it's the first item
                setTimeout(() => {
                    if (data.cart_count === 1) {
                        location.reload();
                    } else {
                        btn.innerHTML = '<i class="fas fa-plus"></i>';
                        btn.classList.remove('bg-bali-orange', 'text-white');
                        btn.classList.add('bg-white/5', 'text-bali-orange');
                        btn.disabled = false;
                        
                        // Update cart count in header
                        const cartCountElement = document.querySelector('.bg-red-600');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        } else {
                            location.reload(); // Fallback to show the badge
                        }
                    }
                }, 800);
            });
        }

        // Service Request functionality
        function toggleServiceOptions() {
            const options = document.querySelectorAll('.service-option');
            options.forEach(opt => opt.classList.toggle('hidden'));
        }

        function requestService(type) {
            let message = '';
            if (type === 'call_waiter') message = 'Memanggil pelayan...';
            else if (type === 'bill') message = 'Meminta tagihan...';
            else if (type === 'clean_table') message = 'Meminta bersihkan meja...';

            fetch('/service-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ request_type: type })
            })
            .then(response => response.json())
            .then(data => {
                showToast(data.message);
                toggleServiceOptions();
            })
            .catch(error => {
                showToast('Terjadi kesalahan, silakan coba lagi.');
            });
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

        // Close Welcome Modal
        function closeWelcomeModal() {
            const modal = document.getElementById('welcomeModal');
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => modal.remove(), 300);
            }
        }
    </script>
</body>
</html>
