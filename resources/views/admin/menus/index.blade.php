@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="section-header">
        <div>
            <h1 class="section-title">Daftar Menu</h1>
            <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Kelola semua item menu restoran</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="btn-bali-primary">
            <i class="fas fa-plus"></i>Tambah Menu
        </a>
    </div>

    <div class="dark-card overflow-hidden">
        <div class="p-5" style="border-bottom:1px solid rgba(255,255,255,0.06);">
            <span class="text-sm" style="color:rgba(255,255,255,0.4);">{{ $menus->total() }} total menu</span>
        </div>
        <div class="overflow-x-auto">
            <table class="dark-table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                    <tr>
                        <td data-label="Gambar">
                            @if($menu->image)
                                <img src="{{ Storage::url($menu->image) }}" 
                                     alt="{{ $menu->name }}" 
                                     class="h-12 w-12 rounded-xl object-cover"
                                     style="border:1px solid rgba(255,255,255,0.08);">
                            @else
                                <div class="h-12 w-12 rounded-xl flex items-center justify-center"
                                     style="background:rgba(255,255,255,0.06); border:1px solid rgba(255,255,255,0.08);">
                                    <i class="fas fa-image" style="color:rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                        </td>
                        <td data-label="Nama Menu">
                            <div class="font-semibold text-white">{{ $menu->name }}</div>
                            @if($menu->description)
                                <div class="text-xs mt-0.5 truncate max-w-xs" style="color:rgba(255,255,255,0.4);">{{ $menu->description }}</div>
                            @endif
                        </td>
                        <td data-label="Kategori">
                            <span style="background:rgba(59,130,246,0.12); color:#60a5fa; border:1px solid rgba(59,130,246,0.25); padding:0.2rem 0.7rem; border-radius:9999px; font-size:0.75rem; font-weight:600;">
                                {{ $menu->category->name }}
                            </span>
                        </td>
                        <td data-label="Harga">
                            <span class="font-semibold" style="color:#14b8a6;">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                        </td>
                        <td data-label="Aksi">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-all"
                                   style="background:rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.3);"
                                   onmouseover="this.style.background='rgba(59,130,246,0.25)';"
                                   onmouseout="this.style.background='rgba(59,130,246,0.15)';">
                                    <i class="fas fa-edit mr-1.5"></i>Edit
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                                      method="POST" class="inline" 
                                      onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-all"
                                            style="background:rgba(239,68,68,0.12); color:#f87171; border:1px solid rgba(239,68,68,0.25);"
                                            onmouseover="this.style.background='rgba(239,68,68,0.22)';"
                                            onmouseout="this.style.background='rgba(239,68,68,0.12)';">
                                        <i class="fas fa-trash mr-1.5"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(255,255,255,0.04);">
                                <i class="fas fa-utensils text-2xl" style="color:rgba(255,255,255,0.2);"></i>
                            </div>
                            <p style="color:rgba(255,255,255,0.4);">Belum ada data menu</p>
                            <a href="{{ route('admin.menus.create') }}" class="btn-bali-primary mt-4 inline-flex">
                                <i class="fas fa-plus"></i>Tambah Menu Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($menus->hasPages())
        <div class="p-5" style="border-top:1px solid rgba(255,255,255,0.06);">
            {{ $menus->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
