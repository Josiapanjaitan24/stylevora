@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<h2 class="fw-bold mb-4">Edit Kategori</h2>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Gambar Kategori</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="max-width: 200px; max-height: 200px; object-fit: cover;" class="rounded">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF (Maks. 2MB). Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
