@extends('layouts.main')

@section('container')
<div class="container mt-5 pb-5">

    <h2>Daftar Movie</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Pemeran</th>
                <th>Cover</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movie as $index => $movie)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $movie->title }}</td>
                <td>{{ $movie->category->category_name }}</td>
                <td>{{ $movie->year }}</td>
                <td>{{ $movie->actors }}</td>
                <td>
                    <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="cover" width="80">
                </td>
                <td>
                    <!-- Tombol Detail -->
                    <a href="/movie/{{ $movie->id }}/{{ $movie->slug }}" class="btn btn-info btn-sm">Detail</a>

                    <!-- Tombol Edit -->
                    <a href="{{ route('movies.editmovie', $movie->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    
                    <!-- Tombol Delete -->
                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin hapus movie ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Belum ada movie.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
