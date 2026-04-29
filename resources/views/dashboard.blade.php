<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white">Dashboard</h2>
                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Selamat datang kembali, {{ Auth::user()->name ?? 'Admin' }}</p>
            </div>
            <div class="flex items-center space-x-2 text-sm" style="color:rgba(255,255,255,0.5);">
                <i class="fas fa-clock text-orange-400"></i>
                <span id="currentTime"></span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Row -->
        @php
            $pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count();
            $processingCount = \App\Models\Order::where('status', 'processing')->count();
            $serviceRequestsCount = \App\Models\ServiceRequest::where('status', 'pending')->count();
            $todayRevenue = \App\Models\Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_price');
        @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="stat-card fade-in-up">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-shopping-cart text-orange-400"></i>
                    </div>
                    <span class="badge-pending">Pending</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1" id="pendingCount" data-current="{{ $pendingOrdersCount }}">{{ $pendingOrdersCount }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.4);">Pesanan Menunggu</div>
            </div>

            <div class="stat-card fade-in-up" style="animation-delay:0.1s;">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(59,130,246,0.15);">
                        <i class="fas fa-fire text-blue-400"></i>
                    </div>
                    <span class="badge-processing">Proses</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1" id="processingCount">{{ $processingCount }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.4);">Sedang Diproses</div>
            </div>

            <div class="stat-card fade-in-up" style="animation-delay:0.2s;">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-bell text-orange-400"></i>
                    </div>
                    <span class="badge-pending">Live</span>
                </div>
                <div class="text-3xl font-bold text-white mb-1" id="serviceCount" data-current="{{ $serviceRequestsCount }}">{{ $serviceRequestsCount }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.4);">Panggilan Layanan</div>
            </div>

            <div class="stat-card fade-in-up" style="animation-delay:0.3s;">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(20,184,166,0.15);">
                        <i class="fas fa-coins text-teal-400"></i>
                    </div>
                    <span class="badge-completed">Hari Ini</span>
                </div>
                <div class="text-xl font-bold text-white mb-1" id="todayRevenue">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
                <div class="text-sm" style="color:rgba(255,255,255,0.4);">Pendapatan Hari Ini</div>
            </div>
        </div>

        <!-- Service Requests -->
        @php
            $serviceRequests = \App\Models\ServiceRequest::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        @endphp

        <div class="dark-card p-6 fade-in-up" style="animation-delay:0.2s;">
            <div class="section-header">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-bell text-orange-400"></i>
                    </div>
                    <div>
                        <h3 class="section-title text-lg">Panggilan Layanan</h3>
                        <p class="text-xs" style="color:rgba(255,255,255,0.4);">Real-time service requests</p>
                    </div>
                </div>
                @if($serviceRequests->count() > 0)
                    <span class="badge-pending">{{ $serviceRequests->count() }} Aktif</span>
                @endif
            </div>

            @if($serviceRequests->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(255,255,255,0.04);">
                        <i class="fas fa-check-circle text-2xl text-teal-400"></i>
                    </div>
                    <p class="font-medium" style="color:rgba(255,255,255,0.6);">Semua bersih!</p>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.3);">Tidak ada panggilan layanan saat ini</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($serviceRequests as $request)
                    <div class="service-card">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" 
                                     style="background:{{ $request->type == 'room' ? 'rgba(59,130,246,0.2)' : 'rgba(20,184,166,0.2)' }}">
                                    <i class="fas fa-{{ $request->type == 'room' ? 'bed text-blue-400' : 'table text-teal-400' }} text-xs"></i>
                                </div>
                                <span class="font-bold text-white text-sm">
                                    {{ $request->type == 'room' ? 'Room' : 'Table' }} {{ $request->number }}
                                </span>
                            </div>
                            <span class="text-xs" style="color:rgba(255,255,255,0.4);">{{ $request->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <p class="text-sm font-medium mb-3" style="color:rgba(255,255,255,0.8);">
                            @if($request->request_type == 'call_waiter')
                                <i class="fas fa-concierge-bell mr-2 text-blue-400"></i>Memanggil Pelayan
                            @elseif($request->request_type == 'bill')
                                <i class="fas fa-file-invoice-dollar mr-2 text-teal-400"></i>Minta Tagihan
                            @elseif($request->request_type == 'clean_table')
                                <i class="fas fa-broom mr-2 text-yellow-400"></i>Bersihkan Meja
                            @endif
                        </p>

                        <form action="{{ route('admin.service.request.resolve', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 text-sm font-semibold rounded-lg transition-all duration-200"
                                    style="background:rgba(20,184,166,0.15); color:#14b8a6; border:1px solid rgba(20,184,166,0.3);"
                                    onmouseover="this.style.background='rgba(20,184,166,0.25)';"
                                    onmouseout="this.style.background='rgba(20,184,166,0.15)';">
                                <i class="fas fa-check mr-2"></i>Tandai Selesai
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pending Orders -->
        @php
            $pendingOrders = \App\Models\Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        @endphp

        <div class="dark-card p-6 fade-in-up" style="animation-delay:0.3s;">
            <div class="section-header">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                        <i class="fas fa-shopping-cart text-orange-400"></i>
                    </div>
                    <div>
                        <h3 class="section-title text-lg">Pesanan Masuk</h3>
                        <p class="text-xs" style="color:rgba(255,255,255,0.4);">Pesanan yang menunggu konfirmasi</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn-bali-secondary text-sm">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if($pendingOrders->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(255,255,255,0.04);">
                        <i class="fas fa-inbox text-2xl text-orange-400"></i>
                    </div>
                    <p class="font-medium" style="color:rgba(255,255,255,0.6);">Tidak ada pesanan baru</p>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.3);">Semua pesanan telah diproses</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="dark-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lokasi</th>
                                <th>Total</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingOrders as $order)
                            <tr>
                                <td>
                                    <span class="font-mono font-bold" style="color:#F97316;">#{{ $order->id }}</span>
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                                             style="background:{{ $order->type == 'room' ? 'rgba(59,130,246,0.15)' : 'rgba(20,184,166,0.15)' }}">
                                            <i class="fas fa-{{ $order->type == 'room' ? 'bed text-blue-400' : 'table text-teal-400' }} text-xs"></i>
                                        </div>
                                        <span class="text-white font-medium">{{ ucfirst($order->type) }} {{ $order->number }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="font-semibold" style="color:#14b8a6;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td style="color:rgba(255,255,255,0.4);">{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-all"
                                       style="background:rgba(249,115,22,0.15); color:#F97316; border:1px solid rgba(249,115,22,0.3);"
                                       onmouseover="this.style.background='rgba(249,115,22,0.25)';"
                                       onmouseout="this.style.background='rgba(249,115,22,0.15)';">
                                        <i class="fas fa-eye mr-1.5"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Live Clock
        function updateTime() {
            const now = new Date();
            const options = { 
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                weekday: 'short', day: 'numeric', month: 'short',
                timeZone: 'Asia/Jakarta'
            };
            const el = document.getElementById('currentTime');
            if (el) el.textContent = now.toLocaleString('id-ID', options) + ' WIB';
        }
        updateTime();
        setInterval(updateTime, 1000);

        // AJAX polling for real-time updates
        function fetchDashboardData() {
            fetch('{{ route("admin.api.dashboard") }}')
                .then(res => res.json())
                .then(data => {
                    // Update stats
                    document.getElementById('pendingCount').textContent = data.pending_count;
                    document.getElementById('processingCount').textContent = data.processing_count;
                    document.getElementById('serviceCount').textContent = data.service_count;
                    document.getElementById('todayRevenue').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.today_revenue);

                    // If counts changed or you want to update lists, we can trigger a reload for now 
                    // until we write full DOM manipulators, or we can just stick to simple reload if DOM manip is too complex.
                    // But since we want "real-time without reload", let's update the lists:
                    if(data.pending_count > 0 || data.service_count > 0) {
                        // For simplicity, if there are new items, we will just reload to get the fresh HTML.
                        // Ideally we would build the HTML here, but a reload on NEW data is better than constant reloads.
                        let currentPending = parseInt(document.getElementById('pendingCount').dataset.current);
                        let currentService = parseInt(document.getElementById('serviceCount').dataset.current);
                        
                        if(data.pending_count !== currentPending || data.service_count !== currentService) {
                            location.reload();
                        }
                    }
                })
                .catch(err => console.error('Polling error:', err));
        }

        // Poll every 10 seconds instead of 30, and only reload if data changed
        setInterval(fetchDashboardData, 10000);
    </script>
</x-app-layout>
