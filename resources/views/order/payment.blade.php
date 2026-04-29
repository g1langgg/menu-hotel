<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - Amanuba Hotel & Resort</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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
        .btn-gradient { background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); transition: all 0.3s ease; }
        .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3); }
        .dark-card { background: #1a1d27; border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="bg-dark-bg text-gray-200">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="w-full max-w-md bg-dark-card rounded-3xl shadow-2xl overflow-hidden border border-white/5">
            <!-- Header -->
            <div class="bg-gradient-to-r from-bali-orange to-orange-600 p-6 text-center text-white relative">
                <div class="absolute top-4 left-4">
                    <a href="{{ route('order.show', $order->id) }}" class="text-white/80 hover:text-white">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <h1 class="text-2xl font-bold mb-1 tracking-wider">QRIS</h1>
                <p class="text-orange-100 text-sm">Pembayaran Digital</p>
            </div>
            
            <div class="p-8">
                <div class="text-center mb-6">
                    <p class="text-white/40 text-sm mb-1">Total Pembayaran</p>
                    <h2 class="text-3xl font-bold text-bali-orange">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h2>
                    <p class="text-xs text-white/20 mt-1">Order #{{ $order->id }}</p>
                </div>

                <!-- QR Code Box -->
                <div class="bg-white/5 rounded-2xl p-6 flex flex-col items-center justify-center mb-6 border border-white/5">
                    @if($dynamicQris)
                        <div id="qrcode" class="p-4 bg-white rounded-xl shadow-sm mb-4"></div>
                        <p class="text-xs text-center text-white/40">Scan menggunakan aplikasi mobile banking atau e-wallet Anda.</p>
                        <script>
                            new QRCode(document.getElementById("qrcode"), {
                                text: "{{ $dynamicQris }}",
                                width: 220,
                                height: 220,
                                colorDark: "#000000",
                                colorLight: "#ffffff",
                                correctLevel: QRCode.CorrectLevel.M
                            });
                        </script>
                    @elseif($qrisImage)
                        <img src="{{ Storage::url($qrisImage) }}" alt="QRIS" class="w-full max-w-[220px] rounded-xl shadow-lg mb-4 bg-white p-2">
                        <p class="text-xs text-center text-white/40">Silakan scan QRIS di atas untuk melakukan pembayaran.</p>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-triangle text-4xl text-yellow-500/50 mb-3"></i>
                            <p class="text-sm text-white/60">Sistem QRIS belum dikonfigurasi oleh admin restoran.</p>
                            <p class="text-xs mt-2 text-white/20">Silakan bayar menggunakan Cash ke kasir/staff.</p>
                        </div>
                    @endif
                </div>

                <!-- Upload Receipt Form -->
                <div class="border-t border-white/5 pt-6">
                    <h3 class="font-bold text-white mb-3 text-center">Sudah Bayar?</h3>
                    <p class="text-xs text-white/40 text-center mb-4">Unggah bukti screenshot transfer Anda di sini agar kami dapat segera memproses pesanan.</p>
                    
                    <form action="{{ route('order.payment.store', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-white/60 mb-2">Bukti Transfer (Max 5MB)</label>
                            <input type="file" name="receipt" accept="image/*" required
                                   class="w-full text-sm text-white/40 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-bali-orange/10 file:text-bali-orange hover:file:bg-bali-orange/20 transition-colors border border-white/5 bg-white/5 rounded-xl p-2 cursor-pointer">
                            @error('receipt')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="w-full btn-gradient text-white py-3 rounded-xl font-bold flex items-center justify-center">
                            <i class="fas fa-upload mr-2"></i>Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="bg-white/5 p-4 text-center border-t border-white/5">
                <p class="text-xs text-white/20"><i class="fas fa-shield-alt mr-1"></i>Transaksi Anda aman</p>
            </div>
        </div>
        
    </div>
</body>
</html>
