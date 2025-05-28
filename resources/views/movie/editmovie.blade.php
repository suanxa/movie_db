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

    <h2>Edit Movie</h2>

    <form action="{{ route('movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Judul</label>
            <input 
                type="text" 
                name="title" 
                class="form-control" 
                value="{{ old('title', $movie->title) }}" 
                required
                id="title"
            >
        </div>

        <!-- Hapus input slug yang terlihat, ganti dengan hidden input -->
        <input 
            type="hidden" 
            name="slug" 
            id="slug" 
            value="{{ old('slug', $movie->slug) }}"
        >

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (old('category_id', $movie->category_id) == $category->id) ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="synopsis" class="form-label">Synopsis</label>
            <textarea 
                name="synopsis" 
                class="form-control" 
                rows="4" 
                required>{{ old('synopsis', $movie->synopsis) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Tahun</label>
            <input 
                type="number" 
                name="year" 
                class="form-control" 
                value="{{ old('year', $movie->year) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="actors" class="form-label">Pemeran</label>
            <input 
                type="text" 
                name="actors" 
                class="form-control" 
                value="{{ old('actors', $movie->actors) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image</label>
            <input 
                type="file" 
                name="cover_image" 
                class="form-control" 
                accept="image/*"
            >
            @if ($movie->cover_image)
                <p class="mt-2">Cover saat ini:</p>
                <img src="{{ asset('images/' . $movie->cover_image) }}" alt="cover" width="120">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .trim()
            .replace(/ /g, '-')       // spasi jadi strip
            .replace(/[^\w\-]+/g, '') // hapus karakter selain huruf, angka, strip
            .replace(/\-\-+/g, '-')   // strip ganda jadi satu
            .replace(/^-+|-+$/g, ''); // hapus strip di awal & akhir
        
        slugInput.value = slug;
    });
</script>
@endsection
