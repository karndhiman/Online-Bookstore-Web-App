@extends('layouts.app')

@section('title', 'Home - Online BookStore')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4">Welcome to Our Online BookStore</h1>
            <p class="lead mb-4">Discover thousands of books from various genres</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">Browse Collection</a>
            <a href="{{ route('sell') }}" class="btn btn-outline-light btn-lg">Sell Your Books</a>
        </div>
    </section>

    <!-- Featured Books -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Featured Books</h2>
            <div class="row">
                @forelse($featuredBooks as $book)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card book-card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x400/4A6572/FFFFFF?text=No+Image' }}" 
                                 class="card-img-top" alt="Book Cover" style="height: 300px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-{{ $book->isAvailable() ? 'success' : 'danger' }}">
                                    {{ $book->isAvailable() ? 'Available' : 'Sold' }}
                                </span>
                            </div>
                            @if($book->condition == 'new')
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-star me-1"></i> New
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ Str::limit($book->title, 50) }}</h5>
                            <p class="card-text text-muted mb-2">by {{ $book->author }}</p>
                            
                            <div class="book-meta mb-3">
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-bookmark me-1 text-primary"></i>{{ $book->genre }}
                                    </span>
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-certificate me-1 text-info"></i>{{ ucfirst($book->condition) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="h4 text-success mb-0">${{ number_format($book->price, 2) }}</span>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </a>
                                    
                                    @if($book->isAvailable())
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-secondary w-100" disabled>
                                        <i class="fas fa-times me-1"></i> Out of Stock
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-book-open fa-4x text-muted"></i>
                        </div>
                        <h3 class="text-muted">No Featured Books Available</h3>
                        <p class="text-muted mb-4">Check out our full collection for more books.</p>
                        <a href="{{ route('books.index') }}" class="btn btn-primary">
                            <i class="fas fa-book me-1"></i> Browse All Books
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            @if(count($featuredBooks) > 0)
            <div class="text-center mt-4">
                <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">
                    View All Books <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            @endif
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                    </div>
                    <h4>Fast Delivery</h4>
                    <p class="text-muted">Get your books delivered quickly with our express shipping</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-undo-alt fa-3x text-primary"></i>
                    </div>
                    <h4>Easy Returns</h4>
                    <p class="text-muted">30-day hassle-free return policy for all your purchases</p>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-headset fa-3x text-primary"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p class="text-muted">Our customer support team is here to help you anytime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number text-primary h2 fw-bold">{{ $totalBooks }}</div>
                    <div class="stat-label text-muted">Books Available</div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number text-primary h2 fw-bold">{{ $totalGenres }}</div>
                    <div class="stat-label text-muted">Genres</div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number text-primary h2 fw-bold">{{ $totalAuthors }}</div>
                    <div class="stat-label text-muted">Authors</div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="stat-number text-primary h2 fw-bold">{{ $soldBooks }}</div>
                    <div class="stat-label text-muted">Books Sold</div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
.book-card {
    transition: all 0.3s ease;
    border: none;
    border-radius: 15px;
    overflow: hidden;
}

.book-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.card-img-top {
    transition: transform 0.3s ease;
}

.book-card:hover .card-img-top {
    transform: scale(1.05);
}

.hero-section {
    background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), 
                url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    color: white;
    padding: 100px 0;
}

.empty-state-icon {
    opacity: 0.7;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}

.stat-number {
    font-size: 2.5rem;
}

.stat-label {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.book-meta .badge {
    font-size: 0.7rem;
}
</style>