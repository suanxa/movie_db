@extends('layouts.main')

@section('container')
<div class="container mt-5 pb-5">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h2>Input Movie Baru</h2>

    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>

        <!-- Slug di-hide, karena otomatis -->
        <input type="hidden" id="slug" name="slug" value="">

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="synopsis" class="form-label">Synopsis</label>
            <textarea name="synopsis" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Tahun</label>
            <input type="number" name="year" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="actors" class="form-label">Pemeran</label>
            <input type="text" name="actors" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>

<script>
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/ /g, '-')       // spasi jadi tanda strip
            .replace(/[^\w-]+/g, '')  // hapus karakter selain huruf, angka, dan strip
            .replace(/--+/g, '-')     // ganti strip ganda jadi satu
            .replace(/^-+|-+$/g, ''); // hapus strip di awal & akhir
        
        slugInput.value = slug;
    });
</script>
@endsection
