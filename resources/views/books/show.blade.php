@extends('layouts.app')

@section('title', $book->title . ' - Online BookStore')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Book Image -->
        <div class="col-md-5">
            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/400x500/4A6572/FFFFFF?text=No+Image' }}" 
                 class="img-fluid rounded shadow" alt="Book Cover" style="height: 500px; object-fit: cover;">
        </div>
        
        <!-- Book Details -->
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('books.index') }}">Books</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($book->title, 30) }}</li>
                </ol>
            </nav>

            <h1 class="display-5">{{ $book->title }}</h1>
            <p class="lead">by {{ $book->author }}</p>
            
            <div class="mb-3">
                <div class="text-warning mb-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="text-muted ms-2">(4.5 • 128 reviews)</span>
                </div>
            </div>

            <div class="mb-4">
                <h2 class="text-success">${{ number_format($book->price, 2) }}</h2>
                <p class="text-{{ $book->isAvailable() ? 'success' : 'danger' }}">
                    <i class="fas fa-{{ $book->isAvailable() ? 'check-circle' : 'times-circle' }}"></i> 
                    {{ $book->isAvailable() ? 'In Stock' : 'Out of Stock' }}
                </p>
                @if($book->isAvailable())
                <p class="text-muted">Quantity Available: {{ $book->quantity }}</p>
                @endif
            </div>

            <div class="mb-4">
                <h5>Description</h5>
                <p>{{ $book->description }}</p>
            </div>

            <div class="mb-4">
                <h5>Details</h5>
                <ul class="list-unstyled">
                    <li><strong>ISBN:</strong> {{ $book->isbn ?? 'Not specified' }}</li>
                    <li><strong>Genre:</strong> {{ $book->genre }}</li>
                    <li><strong>Condition:</strong> {{ ucfirst($book->condition) }}</li>
                    <li><strong>Seller:</strong> {{ $book->user->name }}</li>
                    <li><strong>Listed on:</strong> {{ $book->created_at->format('F j, Y') }}</li>
                </ul>
            </div>

            <!-- Add to Cart Form -->
            @if($book->isAvailable())
            <form action="{{ route('cart.add') }}" method="POST" class="mb-3">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Quantity:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="1" min="1" max="{{ $book->quantity }}" style="width: 80px;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </form>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> This book is currently out of stock.
            </div>
            @endif

            <div class="d-grid gap-2 d-md-flex">
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-heart"></i> Add to Wishlist
                </button>
                <button class="btn btn-outline-secondary">
                    <i class="fas fa-share-alt"></i> Share
                </button>
                @auth
                    @if(Auth::id() === $book->user_id)
                    <button class="btn btn-outline-info">
                        <i class="fas fa-edit"></i> Edit Book
                    </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- More Books from Same Author -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>More from {{ $book->author }}</h3>
            <div class="row">
                @php
                    $relatedBooks = App\Models\Book::where('author', $book->author)
                                                  ->where('id', '!=', $book->id)
                                                  ->where('status', 'available')
                                                  ->where('quantity', '>', 0)
                                                  ->take(4)
                                                  ->get();
                @endphp
                
                @forelse($relatedBooks as $relatedBook)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card book-card h-100 shadow-sm">
                        <img src="{{ $relatedBook->cover_image ? asset('storage/' . $relatedBook->cover_image) : 'https://via.placeholder.com/300x400/4A6572/FFFFFF?text=No+Image' }}" 
                             class="card-img-top" alt="Book Cover" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title">{{ Str::limit($relatedBook->title, 40) }}</h6>
                            <p class="card-text text-success">${{ number_format($relatedBook->price, 2) }}</p>
                            <a href="{{ route('books.show', $relatedBook->id) }}" class="btn btn-outline-primary btn-sm w-100">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No other books by this author currently available.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h3>Customer Reviews</h3>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h2 class="text-warning">4.5/5</h2>
                            <div class="text-warning mb-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="text-muted">Based on 128 reviews</p>
                        </div>
                        <div class="col-md-8">
                            <!-- Sample Review -->
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>John Doe</strong>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="mb-1">Excellent book! Highly recommended for anyone interested in this genre.</p>
                                <small class="text-muted">Reviewed on {{ now()->subDays(5)->format('F j, Y') }}</small>
                            </div>
                            
                            <!-- Another Sample Review -->
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Jane Smith</strong>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <p class="mb-1">Great condition and fast shipping. Will buy from this seller again!</p>
                                <small class="text-muted">Reviewed on {{ now()->subDays(10)->format('F j, Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.book-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 10px;
    overflow: hidden;
}

.book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
@endsection