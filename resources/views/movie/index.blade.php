@extends('layouts.main')
@section('title')
@section('navHome', 'active')

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@section('container')
<h1 class="mt-4 mb-4 text-center fw-bold">Popular Movie</h1>

<div class="container">
    <div class="row">
        @foreach ($movies as $movie)
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 h-100 d-flex flex-row overflow-hidden rounded-4">

                    @if (filter_var($movie->cover_image, FILTER_VALIDATE_URL))
                        <img src="{{ $movie->cover_image }}" 
                            class="card-img-left" 
                            alt="{{ $movie->title }}" 
                            style="width: 40%; height: 100%; object-fit: cover;">
                    @else
                        <img src="{{ asset('images/' . $movie->cover_image) }}" 
                            class="card-img-left" 
                            alt="{{ $movie->title }}" 
                            style="width: 40%; height: 100%; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between p-3" style="width: 60%;">
                        <div>
                            <h5 class="card-title fw-semibold">{{ $movie->title }}</h5>
                            <p class="card-text text-muted small mb-2">{{ Str::limit($movie->synopsis, 100, '...') }}</p>
                            <p class="card-text mb-1"><strong>Year:</strong> {{ $movie->year }}</p>
                            <p class="card-text mb-3"><strong>Category:</strong> {{ $movie->category->category_name ?? 'Tidak ada kategori' }}</p>
                        </div>

                        <a href="/movie/{{ $movie->id }}/{{ $movie->slug }}" class="btn btn-custom align-self-start">Lihat Selanjutnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $movies->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
  .btn-custom {
    background-color: #ff6f00 !important;
    color: #fff !important;
    border: none !important;
    transition: all 0.3s ease;
    padding: 6px 14px;
    border-radius: 8px;
}

.btn-custom:hover {
    background-color: #000000 !important;
    color: #ff6f00 !important;
}


    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    h1 {
        color: #333;
    }
</style>
@endsection
