@extends('admin.layout.master')

@section('content')
<div class="container-fluid px-3 py-4 mt-5">
    <!-- Flash Messages -->
    @include('admin.layout.partials.flash-message')

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold text-dark">Daftar Peyek</h4>
        @if($is_admin)
        <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm px-4">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk
        </a>
        @endif
    </div>

    <!-- Items Grid -->
    <div class="row g-5">
        @forelse($items as $item)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card product-card shadow-sm border-0 h-100">
                <!-- Image Section -->
                <div class="product-image-wrapper">
                    @if($item->gambar)
                    <img src="{{ asset('img_item_upload/' . $item->gambar) }}"
                         class="card-img-top product-image"
                         alt="{{ $item->nama_peyek }}">
                    @else
                    <div class="product-image-placeholder">
                        <i class="bi bi-image"></i>
                    </div>
                    @endif

                    <!-- Status Badge -->
                    <div class="status-badge">
                        @if($item->is_available)
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i>Tersedia
                        </span>
                        @else
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle me-1"></i>Habis
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Content Section -->
                <div class="card-body d-flex flex-column">
                    <!-- Title -->
                    <h5 class="card-title fw-bold mb-2 text-dark">{{ $item->nama_peyek }}</h5>

                    <!-- Topping -->
                    @if($item->topping)
                    <div class="topping-badge mb-2">
                        <i class="bi bi-star-fill text-warning me-1"></i>
                        <span class="small text-muted">{{ $item->topping }}</span>
                    </div>
                    @endif

                    <!-- Description -->
                    @if($item->deskripsi)
                    <p class="card-text text-muted small mb-3 description-text">
                        {{ $item->deskripsi }}
                    </p>
                    @endif

                    <!-- Spacer -->
                    <div class="mt-auto">
                        <!-- Price -->
                        <div class="price-section mb-3">
                            <span class="price-label small text-muted">Harga</span>
                            <h5 class="price-value text-primary fw-bold mb-0">
                                Rp {{ number_format($item->hrg_kiloan, 0, ',', '.') }}
                                <span class="small text-muted fw-normal">/kg</span>
                            </h5>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="{{ route('admin.show', $item->id) }}"
                               class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="bi bi-eye me-1"></i> Lihat Detail
                            </a>

                            @if($is_admin)
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.edit', $item->id) }}"
                                   class="btn btn-warning btn-sm flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $item->id) }}"
                                      method="POST"
                                      class="flex-fill"
                                      onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h5>Belum Ada Produk</h5>
                <p class="text-muted">Belum ada item peyek yang tersedia saat ini</p>
                @if($is_admin)
                <a href="{{ route('admin.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Produk Pertama
                </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    /* Product Card Styling */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12) !important;
    }

    /* Image Section */
    .product-image-wrapper {
        position: relative;
        width: 100%;
        padding-top: 75%; /* 4:3 Aspect Ratio */
        background: #f8f9fa;
        overflow: hidden;
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-image-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .product-image-placeholder i {
        font-size: 3rem;
        color: #adb5bd;
    }

    /* Status Badge */
    .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
    }

    .status-badge .badge {
        padding: 6px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    /* Card Body */
    .card-body {
        padding: 1.25rem;
    }

    .card-title {
        font-size: 1.1rem;
        line-height: 1.4;
        min-height: 2.8rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Topping Badge */
    .topping-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background: #fff3cd;
        border-radius: 15px;
        width: fit-content;
    }

    /* Description */
    .description-text {
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 4.8rem;
    }

    /* Price Section */
    .price-section {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
    }

    .price-label {
        display: block;
        margin-bottom: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .price-value {
        font-size: 1.4rem;
        line-height: 1;
    }

    /* Action Buttons */
    .action-buttons .btn {
        font-size: 0.875rem;
        padding: 8px 16px;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }

    .empty-state i {
        font-size: 4rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    .empty-state h5 {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .card-title {
            font-size: 1rem;
            min-height: auto;
        }

        .price-value {
            font-size: 1.2rem;
        }

        .description-text {
            -webkit-line-clamp: 2;
            min-height: 3.2rem;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .description-text {
            -webkit-line-clamp: 2;
            min-height: 3.2rem;
        }
    }

    /* Smooth Animations */
    .product-card,
    .product-card * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endsection
