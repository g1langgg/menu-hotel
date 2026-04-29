@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto space-y-6">
    <div class="section-header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="btn-bali-secondary px-3 py-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="section-title">Edit Kategori</h1>
                <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Perbarui nama kategori</p>
            </div>
        </div>
    </div>

    <div class="dark-card p-6">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-5">
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

            <div>
                <label for="name" class="dark-label">Nama Kategori <span style="color:#f87171;">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                       class="dark-input" placeholder="Contoh: Makanan Utama" required>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-2" style="border-top:1px solid rgba(255,255,255,0.06);">
                <a href="{{ route('admin.categories.index') }}" class="btn-bali-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-bali-primary">
                    <i class="fas fa-save"></i>Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
