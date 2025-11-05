@extends('layouts.app')

@section('title', 'Search Results - Online BookStore')

@section('content')
<div class="container py-5">
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col">
            <h1>Search Results</h1>
            <p class="lead">Showing results for: "<strong>{{ $query }}</strong>"</p>
            <p class="text-muted">Found {{ rand(5, 20) }} results</p>
        </div>
    </div>

    <!-- Search Results -->
    <div class="row">
        @for($i = 1; $i <= 8; $i++)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card book-card h-100">
                <img src="https://via.placeholder.com/300x400/4A6572/FFFFFF?text=Book+{{ $i }}" 
                     class="card-img-top" alt="Book Cover" style="height: 300px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Book Title {{ $i }} for "{{ $query }}"</h5>
                    <p class="card-text text-muted">Author Name {{ $i }}</p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="h5 text-success mb-0">${{ rand(10, 50) }}</span>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('books.show', $i) }}" class="btn btn-outline-primary">View Details</a>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $i }}">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Related Searches -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Related Searches</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="#" class="btn btn-outline-secondary btn-sm">Books similar to "{{ $query }}"</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">Authors like "{{ $query }}"</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">{{ $query }} series</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">Best {{ $query }} books</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection