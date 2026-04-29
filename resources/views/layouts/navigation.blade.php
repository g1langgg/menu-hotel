<nav style="background:#13161f; border-bottom:1px solid rgba(255,255,255,0.07); position:sticky; top:0; z-index:50;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo + Nav Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('img/logo.png') }}" alt="Amanuba Logo" class="h-10 w-auto">
                        <div class="hidden md:block">
                            <span class="font-bold text-white text-base">AMANUBA</span>
                            <span class="text-[10px] block leading-none uppercase tracking-widest" style="color:rgba(255,255,255,0.4);">Resort & Convention</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:flex items-center space-x-1">
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2 text-xs"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.categories.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-tags mr-2 text-xs"></i>Kategori
                    </a>
                    <a href="{{ route('admin.menus.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.menus.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-utensils mr-2 text-xs"></i>Menu
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.orders.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-shopping-cart mr-2 text-xs"></i>Pesanan
                    </a>
                    <a href="{{ route('admin.qrcode.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.qrcode.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-qrcode mr-2 text-xs"></i>QR Code
                    </a>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.settings.*') ? 'nav-active' : '' }}">
                        <i class="fas fa-cog mr-2 text-xs"></i>Settings
                    </a>
                </div>
            </div>

            <!-- Right side: User dropdown -->
            <div class="hidden sm:flex items-center">
                <div class="relative" id="userDropdownWrapper">
                    <button onclick="toggleUserMenu()" 
                            class="flex items-center space-x-3 px-4 py-2 rounded-xl transition-all duration-200"
                            style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.1); color:#e2e8f0;">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-xs font-bold"
                             style="background:linear-gradient(135deg,#F97316,#EA580C);">
                            {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'G', 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</span>
                        <i class="fas fa-chevron-down text-xs" style="color:rgba(255,255,255,0.4);"></i>
                    </button>

                    <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-52 rounded-xl shadow-2xl overflow-hidden"
                         style="background:#1a1d27; border:1px solid rgba(255,255,255,0.1); z-index:999;">
                        <div class="px-4 py-3" style="border-bottom:1px solid rgba(255,255,255,0.06);">
                            <p class="text-xs font-semibold" style="color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.05em;">Logged in as</p>
                            <p class="text-sm font-medium text-white mt-0.5">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                        </div>
                        <div class="py-1">
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center px-4 py-2.5 text-sm transition-colors"
                               style="color:rgba(255,255,255,0.7);"
                               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='white';"
                               onmouseout="this.style.background=''; this.style.color='rgba(255,255,255,0.7)';">
                                <i class="fas fa-user mr-3 text-xs" style="color:#F97316;"></i>Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center w-full px-4 py-2.5 text-sm transition-colors"
                                        style="color:rgba(255,255,255,0.7);"
                                        onmouseover="this.style.background='rgba(239,68,68,0.08)'; this.style.color='#f87171';"
                                        onmouseout="this.style.background=''; this.style.color='rgba(255,255,255,0.7)';">
                                    <i class="fas fa-sign-out-alt mr-3 text-xs" style="color:#f87171;"></i>Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <div class="flex items-center sm:hidden">
                <button onclick="toggleMobileNavMenu()" 
                        class="p-2 rounded-lg transition-colors"
                        style="color:rgba(255,255,255,0.6); background:rgba(255,255,255,0.06);">
                    <i class="fas fa-bars text-lg"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileNavMenu" class="hidden sm:hidden" style="border-top:1px solid rgba(255,255,255,0.06); background:#13161f;">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('dashboard') ? 'text-white' : '' }}"
               style="{{ request()->routeIs('dashboard') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-tachometer-alt mr-3 text-xs"></i>Dashboard
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
               style="{{ request()->routeIs('admin.categories.*') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-tags mr-3 text-xs"></i>Kategori
            </a>
            <a href="{{ route('admin.menus.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
               style="{{ request()->routeIs('admin.menus.*') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-utensils mr-3 text-xs"></i>Menu
            </a>
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors"
               style="{{ request()->routeIs('admin.orders.*') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-shopping-cart mr-3 text-xs"></i>Pesanan
            </a>
            <a href="{{ route('admin.qrcode.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mt-1"
               style="{{ request()->routeIs('admin.qrcode.*') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-qrcode mr-3 text-xs"></i>QR Code
            </a>
            <a href="{{ route('admin.settings.index') }}" 
               class="flex items-center px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mt-1"
               style="{{ request()->routeIs('admin.settings.*') ? 'background:rgba(249,115,22,0.15); color:#F97316;' : 'color:rgba(255,255,255,0.7);' }}">
                <i class="fas fa-cog mr-3 text-xs"></i>Pengaturan
            </a>
        </div>
        <div class="px-4 py-3" style="border-top:1px solid rgba(255,255,255,0.06);">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold"
                     style="background:linear-gradient(135deg,#F97316,#EA580C);">
                    {{ strtoupper(substr(Auth::check() ? Auth::user()->name : 'G', 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-white">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</p>
                    <p class="text-xs" style="color:rgba(255,255,255,0.4);">{{ Auth::check() ? Auth::user()->email : '' }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 rounded-lg text-sm mb-1"
               style="color:rgba(255,255,255,0.7);">
                <i class="fas fa-user mr-3 text-xs" style="color:#F97316;"></i>Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2 rounded-lg text-sm"
                        style="color:#f87171;">
                    <i class="fas fa-sign-out-alt mr-3 text-xs"></i>Log Out
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
.nav-link {
    display: inline-flex;
    align-items: center;
    padding: 0.45rem 0.875rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.6);
    transition: all 0.2s ease;
    text-decoration: none;
}

.nav-link:hover {
    background: rgba(255, 255, 255, 0.07);
    color: white;
}

.nav-active {
    background: rgba(249, 115, 22, 0.15) !important;
    color: #F97316 !important;
    font-weight: 600;
}
</style>

<script>
function toggleUserMenu() {
    document.getElementById('userDropdownMenu').classList.toggle('hidden');
}

function toggleMobileNavMenu() {
    document.getElementById('mobileNavMenu').classList.toggle('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const wrapper = document.getElementById('userDropdownWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        const menu = document.getElementById('userDropdownMenu');
        if (menu) menu.classList.add('hidden');
    }
});
</script>
