<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Food Ordering System - Bali Hotel Resort</title>
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
                        'bali-palm': '#2D5016'
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .hero-overlay {
            background: linear-gradient(135deg, rgba(58, 125, 68, 0.8) 0%, rgba(139, 94, 60, 0.8) 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #3A7D44 0%, #2D5016 100%);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(58, 125, 68, 0.3);
        }
        
        .timeline-line {
            background: linear-gradient(90deg, #F97316 0%, #3A7D44 100%);
        }
        
        .feature-icon {
            background: linear-gradient(135deg, #F5EFE6 0%, #F8F4E6 100%);
            transition: all 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="bg-bali-cream">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 glass-effect transition-all duration-300" id="navbar">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-auto">
                    <div>
                        <h1 class="text-xl font-bold text-white leading-tight tracking-wider">AMANUBA</h1>
                        <p class="text-[10px] text-white/60 uppercase tracking-[0.3em]">Resort & Convention</p>
                    </div>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-white/90 hover:text-white transition">Fitur</a>
                    <a href="#how-it-works" class="text-white/90 hover:text-white transition">Cara Kerja</a>
                    <a href="#contact" class="text-white/90 hover:text-white transition">Kontak</a>
                    <a href="{{ route('login') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full transition">
                        <i class="fas fa-sign-in-alt mr-2"></i>Admin
                    </a>
                </div>
                
                <button class="md:hidden text-white" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden glass-effect">
            <div class="container mx-auto px-6 py-4 space-y-3">
                <a href="#features" class="block text-white/90 hover:text-white transition">Fitur</a>
                <a href="#how-it-works" class="block text-white/90 hover:text-white transition">Cara Kerja</a>
                <a href="#contact" class="block text-white/90 hover:text-white transition">Kontak</a>
                <a href="{{ route('login') }}" class="block bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-full transition">
                    <i class="fas fa-sign-in-alt mr-2"></i>Admin
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 alt="Bali Resort Dining" 
                 class="w-full h-full object-cover">
            <div class="hero-overlay absolute inset-0"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative z-10 container mx-auto px-6 text-center text-white animate-fade-in">
            <div class="max-w-4xl mx-auto">
                <div class="mb-6 animate-slide-up">
                    <span class="inline-block bg-bali-orange/20 backdrop-blur-sm text-bali-orange px-4 py-2 rounded-full text-sm font-medium">
                        <i class="fas fa-leaf mr-2"></i>Experience Bali's Digital Dining
                    </span>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-slide-up" style="animation-delay: 0.2s">
                    QR Food Ordering
                    <span class="block text-3xl md:text-5xl mt-2 text-bali-cream">System</span>
                </h1>
                
                <p class="text-xl md:text-2xl mb-8 text-bali-cream/90 max-w-2xl mx-auto animate-slide-up" style="animation-delay: 0.4s">
                    Nikmati kemudahan pemesanan makanan langsung dari meja atau kamar Anda dengan sentuhan modern khas Bali
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 0.6s">
                    <a href="/menu?type=table&number=1" 
                       class="btn-primary text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-xl">
                        <i class="fas fa-table mr-3"></i>
                        <span>Pesan di Meja</span>
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                    <a href="/menu?type=room&number=101" 
                       class="btn-secondary text-white px-8 py-4 rounded-2xl font-semibold text-lg shadow-xl">
                        <i class="fas fa-bed mr-3"></i>
                        <span>Room Service</span>
                        <i class="fas fa-arrow-right ml-3"></i>
                    </a>
                </div>
                
                <div class="mt-12 animate-slide-up" style="animation-delay: 0.8s">
                    <div class="flex items-center justify-center space-x-8 text-bali-cream/80">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-bali-orange mr-2"></i>
                            <span>Cepat & Mudah</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-bali-orange mr-2"></i>
                            <span>24/7 Available</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-bali-orange mr-2"></i>
                            <span>Touch-free</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white animate-bounce">
            <i class="fas fa-chevron-down text-2xl"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-bali-sand">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-bali-wood mb-4">
                    Fitur Unggulan
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Teknologi modern yang memudahkan pengalaman dining Anda
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="card-hover bg-white rounded-3xl p-8 shadow-lg text-center">
                    <div class="feature-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-qrcode text-4xl text-bali-orange"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-bali-wood mb-4">Scan QR Code</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Cukup scan QR code yang tersedia di meja atau kamar untuk langsung mengakses menu digital kami
                    </p>
                    <div class="mt-6">
                        <span class="inline-block bg-bali-orange/10 text-bali-orange px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-mobile-alt mr-1"></i>Mobile Friendly
                        </span>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="card-hover bg-white rounded-3xl p-8 shadow-lg text-center">
                    <div class="feature-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shopping-cart text-4xl text-bali-leaf"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-bali-wood mb-4">Pesan Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Interface yang intuitif dengan gambar menarik dan deskripsi lengkap untuk setiap menu
                    </p>
                    <div class="mt-6">
                        <span class="inline-block bg-bali-leaf/10 text-bali-leaf px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-heart mr-1"></i>User Friendly
                        </span>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="card-hover bg-white rounded-3xl p-8 shadow-lg text-center">
                    <div class="feature-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-truck text-4xl text-bali-orange"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-bali-wood mb-4">Antar Cepat</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pesanan langsung terkirim ke dapur dan akan segera diantar ke lokasi Anda
                    </p>
                    <div class="mt-6">
                        <span class="inline-block bg-bali-orange/10 text-bali-orange px-3 py-1 rounded-full text-sm">
                            <i class="fas fa-clock mr-1"></i>Real-time
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold text-bali-wood mb-4">
                    Cara Penggunaan
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    4 langkah mudah untuk menikmati layanan kami
                </p>
            </div>
            
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 timeline-line hidden md:block"></div>
                
                <div class="space-y-12">
                    <!-- Step 1 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-right">
                            <div class="inline-block bg-bali-orange text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg mb-4">
                                1
                            </div>
                            <h3 class="text-2xl font-bold text-bali-wood mb-2">Scan QR</h3>
                            <p class="text-gray-600">Scan QR code yang tersedia di meja atau kamar Anda</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-bali-orange/10 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-qrcode text-2xl text-bali-orange"></i>
                            </div>
                        </div>
                        <div class="flex-1"></div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1"></div>
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-bali-leaf/10 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-utensils text-2xl text-bali-leaf"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="inline-block bg-bali-leaf text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg mb-4">
                                2
                            </div>
                            <h3 class="text-2xl font-bold text-bali-wood mb-2">Pilih Menu</h3>
                            <p class="text-gray-600">Jelajahi menu lengkap dan pilih favorit Anda</p>
                        </div>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1 text-center md:text-right">
                            <div class="inline-block bg-bali-orange text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg mb-4">
                                3
                            </div>
                            <h3 class="text-2xl font-bold text-bali-wood mb-2">Checkout</h3>
                            <p class="text-gray-600">Konfirmasi pesanan dan selesaikan pembayaran</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-bali-orange/10 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-2xl text-bali-orange"></i>
                            </div>
                        </div>
                        <div class="flex-1"></div>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1"></div>
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-bali-leaf/10 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-truck text-2xl text-bali-leaf"></i>
                            </div>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="inline-block bg-bali-leaf text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg mb-4">
                                4
                            </div>
                            <h3 class="text-2xl font-bold text-bali-wood mb-2">Nikmati</h3>
                            <p class="text-gray-600">Duduk santai, pesanan Anda akan segera tiba</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-bali-orange to-bali-leaf">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                Siap Mencoba Pengalaman Baru?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan tamu yang telah menikmati kemudahan QR Food Ordering
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/menu?type=table&number=1" 
                   class="bg-white text-bali-orange px-8 py-4 rounded-2xl font-semibold text-lg hover:shadow-xl transition">
                    <i class="fas fa-rocket mr-2"></i>Mulai Sekarang
                </a>
                <a href="#contact" 
                   class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-2xl font-semibold text-lg hover:bg-white hover:text-bali-orange transition">
                    <i class="fas fa-phone mr-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gradient-to-br from-bali-wood to-bali-palm text-white py-16">
        <div class="container mx-auto px-6">
            <!-- Logo Section -->
            <div class="text-center mb-12">
                <div class="inline-block">
                    <!-- Logo Amanuba -->
                    <img src="{{ asset('img/logo.png') }}" 
                         alt="Amanuba Hotel & Resort" 
                         class="h-32 mx-auto mb-4 object-contain">
                    <h2 class="text-3xl font-bold mb-2 tracking-widest">AMANUBA</h2>
                    <p class="text-white/60 text-sm uppercase tracking-[0.4em]">Resort & Convention</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- QR Food Ordering -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-bali-orange">QR Food Ordering</h3>
                    <p class="text-white/80 mb-4">
                        Solusi digital untuk pengalaman dining yang modern dan nyaman
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center hover:bg-white/20 transition">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-bali-orange">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#features" class="text-white/80 hover:text-white transition">Fitur</a></li>
                        <li><a href="#how-it-works" class="text-white/80 hover:text-white transition">Cara Kerja</a></li>
                        <li><a href="/menu" class="text-white/80 hover:text-white transition">Menu</a></li>
                        <li><a href="{{ route('login') }}" class="text-white/80 hover:text-white transition">Admin Login</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-bali-orange">Layanan</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center text-white/80">
                            <i class="fas fa-check-circle mr-2 text-bali-orange"></i>
                            QR Menu Digital
                        </li>
                        <li class="flex items-center text-white/80">
                            <i class="fas fa-check-circle mr-2 text-bali-orange"></i>
                            Room Service 24/7
                        </li>
                        <li class="flex items-center text-white/80">
                            <i class="fas fa-check-circle mr-2 text-bali-orange"></i>
                            Table Ordering
                        </li>
                        <li class="flex items-center text-white/80">
                            <i class="fas fa-check-circle mr-2 text-bali-orange"></i>
                            Real-time Tracking
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-bali-orange">Hubungi Kami</h4>
                    <div class="space-y-3">
                        <div class="flex items-center text-white/80">
                            <div class="w-10 h-10 bg-bali-orange/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-bali-orange"></i>
                            </div>
                            <div>
                                <p class="font-medium">+62 361 123456</p>
                                <p class="text-sm text-white/60">24/7 Available</p>
                            </div>
                        </div>
                        <div class="flex items-center text-white/80">
                            <div class="w-10 h-10 bg-bali-orange/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-bali-orange"></i>
                            </div>
                            <div>
                                <p class="font-medium">info@amanuba.com</p>
                                <p class="text-sm text-white/60">Email Support</p>
                            </div>
                        </div>
                        <div class="flex items-center text-white/80">
                            <div class="w-10 h-10 bg-bali-orange/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-bali-orange"></i>
                            </div>
                            <div>
                                <p class="font-medium">Jalan Raya Kuta, Bali</p>
                                <p class="text-sm text-white/60">Indonesia 80361</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Section -->
            <div class="border-t border-white/20 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-center md:text-left mb-4 md:mb-0">
                        <p class="text-white/60">&copy; 2026 QR Food Ordering System. All rights reserved.</p>
                        <p class="text-sm text-white/40 mt-1">Powered by Amanuba Hotel & Resort</p>
                    </div>
                    <div class="flex items-center space-x-6 text-white/60 text-sm">
                        <a href="#" class="hover:text-white transition">Privacy Policy</a>
                        <a href="#" class="hover:text-white transition">Terms of Service</a>
                        <a href="#" class="hover:text-white transition">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('bg-bali-wood/90');
                navbar.classList.remove('glass-effect');
            } else {
                navbar.classList.remove('bg-bali-wood/90');
                navbar.classList.add('glass-effect');
            }
        });

        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('hidden');
        }

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.card-hover').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
