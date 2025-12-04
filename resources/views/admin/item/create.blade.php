@extends('admin.layout.master')

@section('content')
<div class="container-fluid px-3 py-4">
    <div class="mb-3">
        <a href="{{ route('admin.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <h4 class="mb-4 fw-bold"
        style="font-family: 'Courier New', Courier, monospace">
        Tambah Item Baru
    </h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_peyek" class="form-label">
                        Nama Peyek <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('nama_peyek') is-invalid @enderror"
                           id="nama_peyek"
                           name="nama_peyek"
                           value="{{ old('nama_peyek') }}"
                           maxlength="50"
                           required>
                    @error('nama_peyek')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="topping" class="form-label">Topping</label>
                    <input type="text"
                           class="form-control @error('topping') is-invalid @enderror"
                           id="topping"
                           name="topping"
                           value="{{ old('topping') }}"
                           maxlength="50"
                           placeholder="Contoh: Kacang, Ikan Teri, dll">
                    @error('topping')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                               value="{{ old('hrg_kiloan') }}"
                               min="0"
                               required>
                        @error('hrg_kiloan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Masukkan harga dalam rupiah</small>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">
                        Gambar Produk <span class="text-danger">*</span>
                    </label>

                    <input type="file"
                           class="form-control @error('gambar') is-invalid @enderror"
                           id="gambar"
                           name="gambar"
                           accept="image/*"
                           onchange="previewImage(event)"
                           required> @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB).</small>

                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <p class="text-muted small mb-1">Preview gambar:</p>
                        <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                              id="deskripsi"
                              name="deskripsi"
                              rows="4"
                              placeholder="Masukkan deskripsi produk...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Status Ketersediaan</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input"
                               type="checkbox"
                               role="switch"
                               id="is_available"
                               name="is_available"
                               value="1"
                               {{ old('is_available', '1') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_available">
                            Produk Tersedia
                        </label>
                    </div>
                    <small class="text-muted">Aktifkan jika produk siap dijual</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-plus-circle"></i> Tambah Data
                    </button>
                    <a href="{{ route('admin.index') }}"
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
