@extends('layouts.main')

@section('title', $movie->title)

@section('container')
<!-- Title Section -->
<h1 class="text-center my-5" style="font-size: 2.5rem; color: #333; font-weight: bold;">{{ $movie->title }}</h1>

<div class="container mt-4">
    <div class="row justify-content-center">
        <!-- Movie Information Section -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-lg border-0 rounded-4">
                <!-- Movie Image -->
                @if (filter_var($movie->cover_image, FILTER_VALIDATE_URL))
                    {{-- Jika cover_image sudah berupa URL lengkap --}}
                    <img src="{{ $movie->cover_image }}" class="card-img-top rounded-4" alt="{{ $movie->title }}" style="object-fit: cover; height: 500px;">
                @else
                    {{-- Jika hanya nama file, gunakan asset() --}}
                    <img src="{{ asset('images/' . $movie->cover_image) }}" class="card-img-top rounded-4" alt="{{ $movie->title }}" style="object-fit: cover; height: 500px;">
                @endif

                <div class="card-body p-4">
                    <!-- Movie Title -->
                    <h5 class="card-title mb-3" style="font-size: 1.75rem; font-weight: 600; color: #333;">{{ $movie->title }}</h5>

                    <!-- Movie Actors -->
                    <p class="card-text" style="font-size: 1.1rem; color: #555; line-height: 1.6;">
                        {{ $movie->actors }}
                    </p>

                    <!-- Movie Synopsis -->
                    <p class="card-text" style="font-size: 1.1rem; color: #555; line-height: 1.6;">
                        {{ $movie->synopsis }}
                    </p>

                    <!-- Movie Year -->
                    <p class="card-text mt-3" style="font-size: 1.2rem; font-weight: 500; color: #777;">
                        <strong>Year:</strong> {{ $movie->year }}
                    </p>

                    <!-- Back Button with a Hover Effect -->
                    <a href="/" class="btn btn-success mt-4 px-4 py-2" style="border-radius: 30px; font-weight: 500; transition: background-color 0.3s;">
                        Back to Movies
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add a footer with some extra info or recommendations -->
<div class="container mt-5 text-center">
    <p class="text-muted" style="font-size: 1rem;">
        This movie is part of our curated collection. Explore more fantastic films!
    </p>
</div>
@endsection
