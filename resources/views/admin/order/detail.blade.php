@extends('admin.layout.master')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/order_detail_admin/style.css') }}">
@endsection

@section('content')
<div class="order-success-container">
    <div class="container">
        <div class="success-card">
            <!-- Header Sukses -->
            <div class="success-header">
                <div class="success-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2>Pesanan</h2>
                <h3>{{ $order->no_order }}</h3>
            </div>

            <!-- Informasi Order -->
            <div class="info-section">
                <h4>Informasi Order</h4>
                <div class="info-item">
                    <span class="info-label">No Order</span>
                    <span class="info-value">{{ $order->no_order }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Pesan</span>
                    <span class="info-value">{{ $order->created_at->format('d-m-Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Metode Pembayaran</span>
                    <span class="info-value">{{ $order->payment_method }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Catatan</span>
                    <span class="info-value">{{ $order->catatan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ str_replace(' ', '-', strtolower($order->status)) }}">
                            {{ strtoupper($order->status) }}
                        </span>
                    </span>
                </div>
            </div>

            <div class="info-section">
                <h4>Pengirim</h4>
                <div class="info-item">
                    <span class="info-label">Nama</span>
                    <span class="info-value">{{ $order->user->nama }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon</span>
                    <span class="info-value">{{ $order->user->telepon }}</span>
                </div>
            </div>

            <!-- Alamat Pengiriman -->
            <div class="info-section">
                <h4>Alamat Pengiriman</h4>
                <div class="info-item">
                    <span class="info-label">Kecamatan</span>
                    <span class="info-value">{{ $order->location->kecamatan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Desa</span>
                    <span class="info-value">{{ $order->location->desa }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat Lengkap</span>
                    <span class="info-value">{{ $order->detail_alamat }}</span>
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="info-section">
                <h4>Detail Produk</h4>
                <div class="product-table-wrapper">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th class="text-black fw-bold">Produk</th>
                                <th class="text-black fw-bold">Jumlah</th>
                                <th class="text-black fw-bold">Harga</th>
                                <th class="text-black fw-bold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotalItems = 0; @endphp
                            @foreach($order->orderItems as $item)
                                @php
                                    $itemQty = $item->jumlah_kg ?? 0;
                                    $itemPrice = $item->harga_per_kg ?? 0;
                                    $subtotal = $itemQty * $itemPrice;
                                    $subtotalItems += $subtotal;
                                @endphp
                                <tr>
                                    <td class="product-name">{{ $item->item->nama_peyek ?? 'N/A' }}</td>
                                    <td>{{ $itemQty }} kg</td>
                                    <td>Rp{{ number_format($itemPrice, 0, ',', '.') }}</td>
                                    <td><strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Pembayaran -->
            <div class="summary-box">
                <h5>Ringkasan Pembayaran</h5>
                <div class="summary-item">
                    <span class="summary-label">Subtotal</span>
                    <span class="summary-value">Rp{{ number_format($subtotalItems, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Ongkir</span>
                    <span class="summary-value">Rp{{ number_format($order->ongkir, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item summary-total">
                    <span class="summary-label">Total Bayar</span>
                    <span class="summary-value">Rp{{ number_format($order->subtotal + $order->ongkir, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if($order->status === 'belum bayar')
                    <form action="{{ route('admin.order.bayar', $order->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-custom-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" style="vertical-align: middle; margin-right: 8px;" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                            </svg>
                            Konfirmasi Pembayaran
                        </button>
                    </form>
                @elseif($order->status === 'diproses')
                    @if($order->payment_method !== 'cash')
                        <div class="paid-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" style="vertical-align: middle; margin-right: 8px;" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Dibayar pada: {{ $order->tanggal_selesai?->format('d-m-Y') }}
                        </div>
                    @else
                        <div class="paid-info">
                           Pesanan COD
                        </div>
                    @endif
                @endif

                <a href="{{ route('admin.order.index') }}" class="btn btn-custom-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" style="vertical-align: middle; margin-right: 8px;" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection
