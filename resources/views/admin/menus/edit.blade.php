@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="section-header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.menus.index') }}" class="btn-bali-secondary px-3 py-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="section-title">Edit Menu</h1>
                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Perbarui informasi menu</p>
            </div>
        </div>
    </div>

    <div class="dark-card p-6">
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            @if ($errors->any())
            <div class="alert-error">
                <div>
                    <p class="font-semibold mb-1">Terdapat kesalahan input:</p>
                    <ul class="list-disc list-inside text-sm space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="dark-label">Nama Menu <span style="color:#f87171;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $menu->name) }}"
                           class="dark-input" placeholder="Contoh: Nasi Goreng Special" required>
                </div>

                <div>
                    <label for="category_id" class="dark-label">Kategori <span style="color:#f87171;">*</span></label>
                    @if($categories->isEmpty())
                        <div class="mt-1 p-3 rounded-xl flex items-center justify-between" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08);">
                            <span class="text-sm" style="color:rgba(255,255,255,0.6);">Belum ada kategori.</span>
                            <a href="{{ route('admin.categories.create') }}" class="text-xs font-semibold text-teal-400 hover:text-teal-300">
                                + Buat Kategori
                            </a>
                        </div>
                        <input type="hidden" name="category_id" value="" required>
                    @else
                        <select id="category_id" name="category_id" class="dark-input" style="appearance:none; cursor:pointer;" required>
                            <option value="" style="background:#1a1d27;">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}
                                        style="background:#1a1d27;">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <div>
                    <label for="price" class="dark-label">Harga (Rp) <span style="color:#f87171;">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $menu->price) }}"
                           step="1000" min="0" class="dark-input" placeholder="Contoh: 45000" required>
                </div>

                <div>
                    <label for="image" class="dark-label">Ganti Gambar</label>
                    @if($menu->image)
                    <div class="mb-3 flex items-center space-x-3 p-3 rounded-xl" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.06);">
                        <img src="{{ Storage::url($menu->image) }}" alt="{{ $menu->name }}"
                             class="h-14 w-14 rounded-xl object-cover" style="border:1px solid rgba(255,255,255,0.08);">
                        <div>
                            <p class="text-xs font-medium" style="color:rgba(255,255,255,0.5);">Gambar saat ini</p>
                            <p class="text-xs mt-0.5" style="color:rgba(255,255,255,0.3);">Upload baru untuk mengganti</p>
                        </div>
                    </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*"
                           class="dark-input" style="padding:0.45rem 0.75rem; cursor:pointer;">
                    <p class="text-xs mt-1.5" style="color:rgba(255,255,255,0.3);">JPEG, PNG, JPG, GIF — Maks. 2MB</p>
                </div>
            </div>

            <div>
                <label for="description" class="dark-label">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="dark-input" placeholder="Deskripsikan menu ini...">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2" style="border-top:1px solid rgba(255,255,255,0.06);">
                <a href="{{ route('admin.menus.index') }}" class="btn-bali-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-bali-primary">
                    <i class="fas fa-save"></i>Update Menu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
