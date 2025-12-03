@extends('admin.layout.master')

@section('content')
<div class="container-fluid px-3 py-4">
    <!-- Flash Messages -->
    @include('admin.layout.partials.flash-message')

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 fw-bold">Daftar Peyek</h4>
        @if($is_admin)
        <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
        @endif
    </div>

    <!-- Items Grid -->
    <div class="row g-3">
        @forelse($items as $item)
        <div class="col-12">
            <a href="{{ route('admin.show', $item->id) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100 card-clickable">
                <div class="row g-0">
                    <!-- Image Section -->
                    <div class="col-4">
                        @if($item->gambar)
                        <img src="{{ asset('img_item_upload/' . $item->gambar) }}"
                             class="img-fluid rounded-start h-100 object-fit-cover"
                             alt="{{ $item->nama_peyek }}"
                             style="min-height: 140px; max-height: 140px;">
                        @else
                        <div class="bg-light rounded-start h-100 d-flex align-items-center justify-content-center"
                             style="min-height: 140px;">
                            <i class="bi bi-image text-muted" style="font-size: 2rem;"></i>
                        </div>
                        @endif
                    </div>

                    <!-- Content Section -->
                    <div class="col-8">
                        <div class="card-body p-3">
                            <!-- Title & Status -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0 fw-bold">{{ $item->nama_peyek }}</h6>
                                @if($item->is_available)
                                <span class="badge bg-success">Tersedia</span>
                                @else
                                <span class="badge bg-danger">Habis</span>
                                @endif
                            </div>

                            <!-- Topping -->
                            @if($item->topping)
                            <p class="text-muted small mb-2">
                                <i class="bi bi-star-fill text-warning"></i> {{ $item->topping }}
                            </p>
                            @endif

                            <!-- Price -->
                            <p class="text-primary fw-bold mb-2">
                                Rp {{ number_format($item->hrg_kiloan, 0, ',', '.') }}/kg
                            </p>

                            <!-- Description -->
                            @if($item->deskripsi)
                            <p class="card-text small text-muted mb-3" style="
                                display: -webkit-box;
                                -webkit-line-clamp: 2;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                            ">
                                {{ $item->deskripsi }}
                            </p>
                            @endif

                            <!-- Action Buttons -->
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
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Belum ada item peyek tersedia
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .object-fit-cover {
        object-fit: cover;
    }

    .card-clickable {
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .card-clickable:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }

    a.text-decoration-none .card-title,
    a.text-decoration-none .card-text {
        color: inherit;
    }
</style>
@endsection
