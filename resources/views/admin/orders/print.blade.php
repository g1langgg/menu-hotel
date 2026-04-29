<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pesanan #{{ $order->id }}</title>
    <style>
        @page {
            size: auto;
            margin: 0mm;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            margin: 0 auto;
            padding: 10mm 5mm;
            color: #000;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 3mm 0;
        }
        .info-table {
            width: 100%;
            margin-bottom: 3mm;
        }
        .info-table td {
            font-size: 11px;
            vertical-align: top;
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            font-size: 11px;
            padding-bottom: 1mm;
        }
        .item-table td {
            padding: 1.5mm 0;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 3mm;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-top: 1mm;
        }
        .footer {
            text-align: center;
            margin-top: 8mm;
            font-size: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 100%;
                margin: 0;
                padding: 5mm;
            }
        }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #F97316;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="btn-print no-print">Cetak Struk</button>

    <div class="header">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 40mm; height: auto; margin-bottom: 3mm; filter: grayscale(100%);">
        <h1>AMANUBA HOTEL</h1>
        <p>Resort & Convention</p>
        <p>Jl. Raya Rancamaya No.1, Bogor</p>
        <p>Telp: (0251) 1234567</p>
    </div>

    <div class="divider"></div>

    <table class="info-table">
        <tr>
            <td>ID Pesanan</td>
            <td class="text-right">#{{ $order->id }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ $order->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td class="text-right">{{ ucfirst($order->type) }} {{ $order->number }}</td>
        </tr>
        <tr>
            <td>Metode Bayar</td>
            <td class="text-right">{{ strtoupper($order->payment_method) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="item-table">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    {{ $item->menu->name }}<br>
                    <small>{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }}</small>
                </td>
                <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="total-section">
        <div class="total-row" style="font-weight: normal; font-size: 11px;">
            <span>Subtotal</span>
            <span>Rp {{ number_format($order->total_price / 1.1, 0, ',', '.') }}</span>
        </div>
        <div class="total-row" style="font-weight: normal; font-size: 11px;">
            <span>Pajak (10%)</span>
            <span>Rp {{ number_format($order->total_price * 0.1 / 1.1, 0, ',', '.') }}</span>
        </div>
        <div class="divider" style="border-top-style: solid; opacity: 0.2;"></div>
        <div class="total-row" style="font-size: 14px;">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    @if($order->notes)
    <div style="font-size: 10px; font-style: italic;">
        <strong>Catatan:</strong> {{ $order->notes }}
    </div>
    <div class="divider"></div>
    @endif

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Silakan Datang Kembali</p>
        <p style="margin-top: 5mm; opacity: 0.5;">Powered by QR Food System</p>
    </div>

    <script>
        // Auto print when page loads if not in dev mode or just keep the button
        window.onload = function() {
            // setTimeout(() => window.print(), 500);
        }
    </script>
</body>
</html>
