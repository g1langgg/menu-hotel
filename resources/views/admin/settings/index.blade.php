@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="section-header">
        <h1 class="section-title">Pengaturan Sistem</h1>
        <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Konfigurasi fitur-fitur restoran Anda</p>
    </div>

    @if (session('success'))
        <div class="alert-success mb-6">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="dark-card p-6">
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                <i class="fas fa-qrcode text-orange-400 text-lg"></i>
            </div>
            <div>
                <h3 class="font-semibold text-white text-lg">Pengaturan QRIS Dinamis</h3>
                <p class="text-sm" style="color:rgba(255,255,255,0.5);">Konfigurasi teks QRIS statis Anda untuk membuat QRIS dengan nominal otomatis</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="qris_base_string" class="dark-label block mb-2">QRIS Base String (EMVCo)</label>
                    <textarea id="qris_base_string" name="qris_base_string" rows="8"
                              class="dark-input w-full font-mono text-sm" 
                              placeholder="Paste hasil scan QRIS statis Anda di sini. Biasanya dimulai dengan '000201010211...'">{{ old('qris_base_string', $qrisBaseString) }}</textarea>
                    <p class="text-xs mt-2" style="color:rgba(255,255,255,0.3);">Gunakan ini jika ingin nominal pembayaran muncul otomatis (Dinamis).</p>
                </div>

                <div>
                    <label for="qris_image" class="dark-label block mb-2">Atau Upload Gambar QRIS (Statis)</label>
                    @if($qrisImage)
                        <div class="mb-3 p-3 rounded-xl bg-white/5 border border-white/10 flex items-center space-x-3">
                            <img src="{{ Storage::url($qrisImage) }}" alt="QRIS" class="w-20 h-20 object-contain rounded-lg bg-white p-1">
                            <div>
                                <p class="text-xs font-semibold text-white">QRIS Terpasang</p>
                                <p class="text-[10px]" style="color:rgba(255,255,255,0.4);">Ganti dengan upload baru</p>
                            </div>
                        </div>
                    @endif
                    <input type="file" id="qris_image" name="qris_image" accept="image/*"
                           class="dark-input w-full" style="padding: 0.5rem;">
                    <p class="text-xs mt-2" style="color:rgba(255,255,255,0.3);">Upload gambar QRIS jika Anda tidak memiliki Base String.</p>
                </div>
            </div>

            <div class="mb-6 p-4 rounded-xl" style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08);">
                <h4 class="text-sm font-semibold text-white mb-2"><i class="fas fa-info-circle text-teal-400 mr-2"></i>Tips Konfigurasi:</h4>
                <ol class="list-decimal list-inside text-xs space-y-1.5" style="color:rgba(255,255,255,0.6);">
                    <li><strong>QRIS Dinamis:</strong> Scan QRIS Anda dengan aplikasi scanner biasa (misal: Google Lens), copy teksnya, lalu paste di kotak kiri.</li>
                    <li><strong>QRIS Statis:</strong> Cukup upload foto/screenshot QRIS Anda di kotak kanan jika tidak ingin menggunakan fitur dinamis.</li>
                </ol>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4" style="border-top:1px solid rgba(255,255,255,0.06);">
                <button type="submit" class="btn-bali-primary px-6 py-2.5">
                    <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
