@extends('admin.layout.master')

@section('content')
<div class="container-fluid px-3 py-4">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Item Detail Card -->
    <div class="card shadow-sm border-0">
        <!-- Image -->
        @if($item->gambar)
        <img src="{{ asset('img_item_upload/' . $item->gambar) }}"
             class="card-img-top"
             alt="{{ $item->nama_peyek }}"
             style="max-height: 300px; object-fit: cover;">
        @else
        <div class="bg-light d-flex align-items-center justify-content-center"
             style="height: 300px;">
            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
        </div>
        @endif

        <div class="card-body">
            <!-- Title & Status -->
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h4 class="card-title mb-0 fw-bold">{{ $item->nama_peyek }}</h4>
                @if($item->is_available)
                <span class="badge bg-success">Tersedia</span>
                @else
                <span class="badge bg-danger">Habis</span>
                @endif
            </div>

            <!-- Item ID -->
            <div class="mb-3">
                <small class="text-muted">ID: {{ $item->id }}</small>
            </div>

            <!-- Topping -->
            @if($item->topping)
            <div class="mb-3">
                <h6 class="text-muted mb-1">
                    <i class="bi bi-star-fill text-warning"></i> Topping
                </h6>
                <p class="mb-0">{{ $item->topping }}</p>
            </div>
            @endif

            <!-- Price -->
            <div class="mb-3">
                <h6 class="text-muted mb-1">
                    <i class="bi bi-cash-coin text-success"></i> Harga
                </h6>
                <h5 class="text-primary fw-bold mb-0">
                    Rp {{ number_format($item->hrg_kiloan, 0, ',', '.') }}/kg
                </h5>
            </div>

            <!-- Description -->
            @if($item->deskripsi)
            <div class="mb-3">
                <h6 class="text-muted mb-2">
                    <i class="bi bi-card-text"></i> Deskripsi
                </h6>
                <p class="card-text">{{ $item->deskripsi }}</p>
            </div>
            @endif

            <!-- Action Buttons (Admin Only) -->
            @if($is_admin)
            <div class="d-flex gap-2 mt-4">
                <a href="{{ route('admin.edit', $item->id) }}"
                   class="btn btn-warning flex-fill">
                    <i class="bi bi-pencil"></i> Edit Item
                </a>
                <form action="{{ route('admin.destroy', $item->id) }}"
                      method="POST"
                      class="flex-fill"
                      onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
