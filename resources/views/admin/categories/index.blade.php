@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="section-header">
        <div>
            <h1 class="section-title">Daftar Kategori</h1>
            <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Kelola kategori menu restoran</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-bali-primary">
            <i class="fas fa-plus"></i>Tambah Kategori
        </a>
    </div>

    <div class="dark-card overflow-hidden">
        <div class="p-5" style="border-bottom:1px solid rgba(255,255,255,0.06);">
            <span class="text-sm" style="color:rgba(255,255,255,0.4);">{{ $categories->total() }} total kategori</span>
        </div>
        <div class="overflow-x-auto">
            <table class="dark-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Menu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td style="color:rgba(255,255,255,0.4);">
                            {{ ($categories->currentpage() - 1) * $categories->perpage() + $index + 1 }}
                        </td>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                                    <i class="fas fa-tag text-orange-400 text-xs"></i>
                                </div>
                                <span class="font-semibold text-white">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span style="background:rgba(20,184,166,0.12); color:#14b8a6; border:1px solid rgba(20,184,166,0.25); padding:0.2rem 0.75rem; border-radius:9999px; font-size:0.75rem; font-weight:600;">
                                {{ $category->menus->count() }} menu
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-all"
                                   style="background:rgba(59,130,246,0.15); color:#60a5fa; border:1px solid rgba(59,130,246,0.3);"
                                   onmouseover="this.style.background='rgba(59,130,246,0.25)';"
                                   onmouseout="this.style.background='rgba(59,130,246,0.15)';">
                                    <i class="fas fa-edit mr-1.5"></i>Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                      method="POST" class="inline" 
                                      onsubmit="return confirm('Hapus kategori ini?')">
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
                        <td colspan="4" class="text-center py-16">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4" style="background:rgba(255,255,255,0.04);">
                                <i class="fas fa-tags text-2xl" style="color:rgba(255,255,255,0.2);"></i>
                            </div>
                            <p style="color:rgba(255,255,255,0.4);">Belum ada data kategori</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="p-5" style="border-top:1px solid rgba(255,255,255,0.06);">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
