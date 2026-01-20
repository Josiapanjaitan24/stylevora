@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="fw-bold">Manajemen Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-danger">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">Gambar</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Produk</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-muted small"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $category->name }}</td>
                            <td>{{ substr($category->description, 0, 50) }}{{ strlen($category->description) > 50 ? '...' : '' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $category->products()->count() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox" style="font-size: 40px;"></i>
                                <p class="mt-2">Belum ada kategori</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
