@extends('admin.layout.master')

@section('content')
<div class="container-fluid px-3 py-4">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('admin.show', $item->id) }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Header -->
    <h4 class="mb-4 fw-bold">Edit Item Peyek</h4>

    <!-- Edit Form -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.update', $item->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nama Peyek -->
                <div class="mb-3">
                    <label for="nama_peyek" class="form-label">
                        Nama Peyek <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('nama_peyek') is-invalid @enderror"
                           id="nama_peyek"
                           name="nama_peyek"
                           value="{{ old('nama_peyek', $item->nama_peyek) }}"
                           maxlength="50"
                           required>
                    @error('nama_peyek')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Topping -->
                <div class="mb-3">
                    <label for="topping" class="form-label">Topping</label>
                    <input type="text"
                           class="form-control @error('topping') is-invalid @enderror"
                           id="topping"
                           name="topping"
                           value="{{ old('topping', $item->topping) }}"
                           maxlength="50"
                           placeholder="Contoh: Kacang, Ikan Teri, dll">
                    @error('topping')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Harga Kiloan -->
                <div class="mb-3">
                    <label for="hrg_kiloan" class="form-label">
                        Harga per Kilogram <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number"
                               class="form-control @error('hrg_kiloan') is-invalid @enderror"
                               id="hrg_kiloan"
                               name="hrg_kiloan"
                               value="{{ old('hrg_kiloan', $item->hrg_kiloan) }}"
                               min="0"
                               required>
                        @error('hrg_kiloan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Masukkan harga dalam rupiah</small>
                </div>

                <!-- Gambar -->
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Produk</label>

                    <!-- Preview Gambar Lama -->
                    @if($item->gambar)
                    <div class="mb-2">
                        <img src="{{ asset('img_item_upload/' . $item->gambar) }}"
                             alt="Current Image"
                             class="img-thumbnail"
                             style="max-height: 150px;">
                        <p class="text-muted small mt-1">Gambar saat ini</p>
                    </div>
                    @endif

                    <input type="file"
                           class="form-control @error('gambar') is-invalid @enderror"
                           id="gambar"
                           name="gambar"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB). Kosongkan jika tidak ingin mengubah.</small>

                    <!-- Preview Gambar Baru -->
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <p class="text-muted small mb-1">Preview gambar baru:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi"
                              name="deskripsi"
                              rows="4"
                              placeholder="Masukkan deskripsi produk...">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Ketersediaan -->
                <div class="mb-4">
                    <label class="form-label">Status Ketersediaan</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="is_available"
                               name="is_available"
                               value="1"
                               {{ old('is_available', $item->is_available) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">
                            Produk Tersedia
                        </label>
                    </div>
                    <small class="text-muted">Aktifkan jika produk masih tersedia untuk dijual</small>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.show', $item->id) }}"
                       class="btn btn-secondary flex-fill">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}
</script>
@endsection
