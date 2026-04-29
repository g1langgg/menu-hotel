@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="section-header">
        <div>
            <h1 class="section-title">QR Code Generator</h1>
            <p class="text-sm mt-0.5" style="color:rgba(255,255,255,0.4);">Generate QR code untuk meja & kamar</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Generator Panel -->
        <div class="dark-card p-6">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(249,115,22,0.15);">
                    <i class="fas fa-qrcode text-orange-400"></i>
                </div>
                <h2 class="font-semibold text-white text-lg">Buat QR Code</h2>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="dark-label">Tipe Lokasi</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="setType('table')" id="btn-table"
                                class="type-btn active-type flex items-center justify-center space-x-2 py-3 rounded-xl font-semibold text-sm transition-all"
                                style="border:2px solid #F97316; background:rgba(249,115,22,0.15); color:#F97316;">
                            <i class="fas fa-table"></i><span>Meja (Table)</span>
                        </button>
                        <button onclick="setType('room')" id="btn-room"
                                class="type-btn flex items-center justify-center space-x-2 py-3 rounded-xl font-semibold text-sm transition-all"
                                style="border:2px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.5);">
                            <i class="fas fa-bed"></i><span>Kamar (Room)</span>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="dark-label" id="numberLabel">Nomor Meja</label>
                    <input type="number" id="locationNumber" value="1" min="1" max="999"
                           class="dark-input" placeholder="Masukkan nomor"
                           oninput="generateQR()">
                </div>

                <div>
                    <label class="dark-label">Preview URL</label>
                    <div class="dark-input flex items-center space-x-2" id="previewUrl"
                         style="background:rgba(255,255,255,0.03); word-break:break-all; font-size:0.8rem; color:rgba(255,255,255,0.5);">
                        —
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button onclick="downloadQR('png')" class="btn-bali-primary flex-1 justify-center">
                        <i class="fas fa-download"></i>Download PNG
                    </button>
                    <button onclick="printQR()" class="btn-bali-secondary flex-1 justify-center">
                        <i class="fas fa-print"></i>Print
                    </button>
                </div>
            </div>
        </div>

        <!-- QR Preview -->
        <div class="dark-card p-6 flex flex-col items-center justify-center">
            <div id="qrPreviewContainer" class="text-center">
                <div id="qrcode" class="mx-auto mb-4 rounded-2xl overflow-hidden p-4"
                     style="background:white; display:inline-block;"></div>
                <div id="qrLabel" class="mt-4">
                    <p class="text-white font-bold text-lg" id="qrLabelType">Table 1</p>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.4);">Amanuba Hotel & Resort</p>
                    <p class="text-xs mt-1" style="color:rgba(255,255,255,0.3);">Scan to order</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Generator -->
    <div class="dark-card p-6">
        <div class="flex items-center space-x-3 mb-5">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(20,184,166,0.15);">
                <i class="fas fa-layer-group text-teal-400"></i>
            </div>
            <div>
                <h2 class="font-semibold text-white text-lg">Bulk Generator</h2>
                <p class="text-xs" style="color:rgba(255,255,255,0.4);">Generate banyak QR sekaligus & print semua</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-5">
            <div>
                <label class="dark-label">Tipe</label>
                <select id="bulkType" class="dark-input" style="appearance:none; cursor:pointer;">
                    <option value="table" style="background:#1a1d27;">Meja (Table)</option>
                    <option value="room" style="background:#1a1d27;">Kamar (Room)</option>
                </select>
            </div>
            <div>
                <label class="dark-label">Dari Nomor</label>
                <input type="number" id="bulkFrom" value="1" min="1" class="dark-input">
            </div>
            <div>
                <label class="dark-label">Sampai Nomor</label>
                <input type="number" id="bulkTo" value="10" min="1" class="dark-input">
            </div>
        </div>

        <div id="bulkPreview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-5" style="display:none!important;"></div>

        <div class="flex gap-3">
            <button onclick="generateBulk()" class="btn-bali-primary">
                <i class="fas fa-magic"></i>Generate Semua
            </button>
            <button onclick="printBulk()" id="printBulkBtn" class="btn-bali-secondary" style="display:none;">
                <i class="fas fa-print"></i>Print Semua
            </button>
        </div>

        <div id="bulkGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-5"></div>
    </div>
</div>

<!-- Print styles -->
<style>
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: fixed; top: 0; left: 0; width: 100%; }
}
.type-btn { cursor: pointer; }
</style>

<div id="printArea" style="display:none;"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
let currentType = 'table';
let qrInstance = null;
const BASE_URL = '{{ url("/menu") }}';

function setType(type) {
    currentType = type;
    document.getElementById('numberLabel').textContent = type === 'table' ? 'Nomor Meja' : 'Nomor Kamar';
    document.getElementById('btn-table').style.cssText = type === 'table'
        ? 'border:2px solid #F97316; background:rgba(249,115,22,0.15); color:#F97316;'
        : 'border:2px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.5);';
    document.getElementById('btn-room').style.cssText = type === 'room'
        ? 'border:2px solid #F97316; background:rgba(249,115,22,0.15); color:#F97316;'
        : 'border:2px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.04); color:rgba(255,255,255,0.5);';
    generateQR();
}

function buildUrl(type, number) {
    return `${BASE_URL}?type=${type}&number=${number}`;
}

function generateQR() {
    const number = document.getElementById('locationNumber').value || '1';
    const url = buildUrl(currentType, number);
    document.getElementById('previewUrl').textContent = url;
    document.getElementById('qrLabelType').textContent =
        (currentType === 'table' ? 'Table' : 'Room') + ' ' + number;

    const container = document.getElementById('qrcode');
    container.innerHTML = '';
    new QRCode(container, {
        text: url,
        width: 200,
        height: 200,
        colorDark: '#1a1d27',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
}

function downloadQR(format) {
    const number = document.getElementById('locationNumber').value || '1';
    const canvas = document.querySelector('#qrcode canvas');
    if (!canvas) return alert('Generate QR dulu!');

    // Add label to canvas
    const offscreen = document.createElement('canvas');
    offscreen.width = 260; offscreen.height = 300;
    const ctx = offscreen.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, 260, 300);
    ctx.drawImage(canvas, 30, 20, 200, 200);
    ctx.fillStyle = '#1a1d27';
    ctx.font = 'bold 18px Inter, sans-serif';
    ctx.textAlign = 'center';
    ctx.fillText((currentType === 'table' ? 'Table' : 'Room') + ' ' + number, 130, 245);
    ctx.font = '12px Inter, sans-serif';
    ctx.fillStyle = '#666';
    ctx.fillText('Amanuba Hotel & Resort', 130, 265);
    ctx.fillText('Scan to order', 130, 283);

    const link = document.createElement('a');
    link.download = `QR-${currentType}-${number}.png`;
    link.href = offscreen.toDataURL('image/png');
    link.click();
}

function printQR() {
    const number = document.getElementById('locationNumber').value || '1';
    const canvas = document.querySelector('#qrcode canvas');
    if (!canvas) return;
    const imgData = canvas.toDataURL();
    const label = (currentType === 'table' ? 'Table' : 'Room') + ' ' + number;
    const printArea = document.getElementById('printArea');
    printArea.style.display = 'block';
    printArea.innerHTML = `
        <div style="text-align:center; padding:40px; font-family:Inter,sans-serif;">
            <h2 style="font-size:24px; font-weight:bold; margin-bottom:8px;">Amanuba Hotel & Resort</h2>
            <p style="color:#666; margin-bottom:20px;">Scan QR untuk memesan</p>
            <img src="${imgData}" style="width:200px; height:200px;">
            <h3 style="font-size:28px; font-weight:bold; margin-top:16px;">${label}</h3>
            <p style="color:#888; font-size:14px; margin-top:4px;">QR Food Ordering System</p>
        </div>`;
    window.print();
    printArea.style.display = 'none';
}

function generateBulk() {
    const type = document.getElementById('bulkType').value;
    const from = parseInt(document.getElementById('bulkFrom').value) || 1;
    const to   = parseInt(document.getElementById('bulkTo').value) || 10;
    if (to - from > 49) return alert('Maksimal 50 QR sekaligus!');

    const grid = document.getElementById('bulkGrid');
    grid.innerHTML = '';
    document.getElementById('printBulkBtn').style.display = 'inline-flex';

    for (let i = from; i <= to; i++) {
        const url = buildUrl(type, i);
        const card = document.createElement('div');
        card.style.cssText = 'background:#1a1d27; border:1px solid rgba(255,255,255,0.08); border-radius:12px; padding:12px; text-align:center;';
        const qrDiv = document.createElement('div');
        qrDiv.style.cssText = 'background:white; border-radius:8px; padding:6px; display:inline-block; margin-bottom:8px;';
        card.appendChild(qrDiv);
        const label = document.createElement('p');
        label.style.cssText = 'color:white; font-size:0.8rem; font-weight:600;';
        label.textContent = (type === 'table' ? 'Table' : 'Room') + ' ' + i;
        card.appendChild(label);
        grid.appendChild(card);
        new QRCode(qrDiv, { text: url, width: 100, height: 100, colorDark: '#1a1d27', colorLight: '#ffffff', correctLevel: QRCode.CorrectLevel.M });
    }
}

function printBulk() {
    const cards = document.querySelectorAll('#bulkGrid > div');
    const type  = document.getElementById('bulkType').value;
    const from  = parseInt(document.getElementById('bulkFrom').value);

    let html = '<div style="font-family:Inter,sans-serif;">';
    html += '<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; padding:20px;">';

    cards.forEach((card, i) => {
        const canvas = card.querySelector('canvas');
        if (!canvas) return;
        const imgData = canvas.toDataURL();
        const num = from + i;
        html += `<div style="text-align:center; border:1px solid #ddd; border-radius:8px; padding:12px;">
            <img src="${imgData}" style="width:100px; height:100px;">
            <p style="font-weight:bold; margin-top:8px;">${type === 'table' ? 'Table' : 'Room'} ${num}</p>
            <p style="color:#888; font-size:11px;">Amanuba Hotel</p>
        </div>`;
    });
    html += '</div></div>';

    const printArea = document.getElementById('printArea');
    printArea.style.display = 'block';
    printArea.innerHTML = html;
    window.print();
    printArea.style.display = 'none';
}

// Init on load
window.addEventListener('load', generateQR);
</script>
@endsection
