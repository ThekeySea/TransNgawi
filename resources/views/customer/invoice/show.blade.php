<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice — {{ $booking->code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #1a1a1a;
            background: #fff;
            font-size: 13px;
            line-height: 1.5;
        }
        .invoice {
            max-width: 700px;
            margin: 0 auto;
            padding: 32px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            border-bottom: 3px solid #ff750f;
            padding-bottom: 20px;
        }
        .brand h1 {
            font-size: 22px;
            font-weight: 800;
            color: #ff750f;
            letter-spacing: -0.5px;
        }
        .brand p {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .invoice-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a1a;
        }
        .header-right .invoice-date {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }
        .barcode {
            text-align: center;
            margin: 20px 0;
        }
        .barcode img {
            max-height: 60px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            width: 50%;
            padding: 6px 12px 6px 0;
            vertical-align: top;
        }
        .info-cell:nth-child(2) {
            padding-right: 0;
        }
        .info-label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .info-value {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 2px;
        }
        .status-badge {
            display: inline-block;
            background: #22c55e;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table-section {
            margin-bottom: 24px;
        }
        .table-section h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a1a1a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead th {
            background: #f5f5f5;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            padding: 10px 12px;
            text-align: left;
            border-bottom: 2px solid #e5e5e5;
        }
        table thead th:last-child {
            text-align: right;
        }
        table tbody td {
            padding: 10px 12px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }
        table tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        .total-section {
            border-top: 2px solid #1a1a1a;
            padding-top: 12px;
            margin-top: 8px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .total-label {
            font-size: 14px;
            font-weight: 600;
        }
        .total-amount {
            font-size: 20px;
            font-weight: 800;
            color: #ff750f;
        }
        .paid-badge {
            display: inline-block;
            background: #22c55e;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            padding: 4px 12px;
            border-radius: 4px;
            margin-left: 12px;
            letter-spacing: 0.5px;
        }
        .passenger-section {
            margin-bottom: 24px;
        }
        .passenger-section h3 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #1a1a1a;
        }
        .passenger-grid {
            display: table;
            width: 100%;
        }
        .passenger-row {
            display: table-row;
        }
        .passenger-cell {
            display: table-cell;
            width: 33%;
            padding: 6px 12px 6px 0;
        }
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 11px;
            color: #888;
        }
        @media print {
            .invoice { padding: 0; max-width: none; }
        }
    </style>
</head>
<body>
    <div class="invoice">
        {{-- Header --}}
        <div class="header">
            <div class="brand">
                <h1>TransNgawi</h1>
                <p>Perjalanan Nyaman, Tanpa Bikin Kantong Berat</p>
            </div>
            <div class="header-right">
                <div class="invoice-title">INVOICE</div>
                <div class="invoice-date">{{ $booking->paid_at?->format('d M Y H:i') ?: $booking->created_at->format('d M Y H:i') }}</div>
            </div>
        </div>

        {{-- Barcode --}}
        <div class="barcode">
            <img src="data:image/png;base64,{{ $barcodeBase64 }}" alt="Barcode {{ $booking->code }}">
        </div>

        {{-- Info Grid --}}
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Kode Transaksi</div>
                    <div class="info-value">{{ $booking->code }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Kode Perjalanan</div>
                    <div class="info-value">{{ $booking->trip->trip_code }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Plat Nomor Bus</div>
                    <div class="info-value">{{ $booking->trip->bus->plate_number }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Tanggal Pemesanan</div>
                    <div class="info-value">{{ $booking->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Rute Perjalanan</div>
                    <div class="info-value">{{ $booking->trip->route->origin->name }} → {{ $booking->trip->route->destination->name }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Tanggal & Waktu Berangkat</div>
                    <div class="info-value">{{ $booking->trip->departs_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Layanan</div>
                    <div class="info-value">{{ $booking->trip->route->service_category->label() }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Jumlah Tiket</div>
                    <div class="info-value">{{ $booking->seats->count() }} kursi</div>
                </div>
            </div>
        </div>

        {{-- Passenger --}}
        <div class="passenger-section">
            <h3>Data Penumpang</h3>
            <div class="passenger-grid">
                <div class="passenger-row">
                    <div class="passenger-cell">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $booking->passenger_name }}</div>
                    </div>
                    <div class="passenger-cell">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $booking->passenger_email }}</div>
                    </div>
                    <div class="passenger-cell">
                        <div class="info-label">Telepon</div>
                        <div class="info-value">{{ $booking->passenger_phone }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Price Breakdown --}}
        <div class="table-section">
            <h3>Detail Harga</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kursi</th>
                        <th>Kelas</th>
                        <th>Harga Unit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->seats as $seat)
                        <tr>
                            <td style="font-weight: 700;">{{ $seat->seat_code }}</td>
                            <td>{{ $seat->class_name }}</td>
                            <td>Rp {{ number_format($seat->fare_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Total --}}
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Total Terbayar</div>
                <div>
                    <span class="total-amount">Rp {{ number_format($booking->total, 0, ',', '.') }}</span>
                    <span class="paid-badge">LUNAS</span>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Invoice ini sah dan dikeluarkan oleh sistem TransNgawi.</p>
            <p>Simpan tiket ini dan tunjukkan saat boarding. Terima kasih telah memilih TransNgawi.</p>
        </div>
    </div>
</body>
</html>
