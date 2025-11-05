@extends('layouts.app')

@section('title', 'Browse Books - Online BookStore')

@section('content')
<div class="container py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-4">Browse Our Collection</h1>
            <p class="lead text-muted">Discover thousands of books from various genres</p>
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-sort"></i> Sort by: Featured
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                    <li><a class="dropdown-item" href="#">Newest First</a></li>
                    <li><a class="dropdown-item" href="#">Highest Rated</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Books Count and Filter Info -->
    <div class="row mb-4">
        <div class="col">
            <p class="text-muted mb-0">Showing {{ $books->count() }} books</p>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        @forelse($books as $book)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
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
                    <h5 class="card-title text-dark">{{ Str::limit($book->title, 50) }}</h5>
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
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-book-open fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted">No Books Available</h3>
                <p class="text-muted mb-4">We couldn't find any books matching your criteria.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </a>
                    <a href="{{ route('sell') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Sell Your Book
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Books pagination">
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if($books->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $books->previousPageUrl() }}">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $books->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($books->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $books->nextPageUrl() }}">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </span>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif

    <!-- Quick Stats Section -->
    <div class="row mt-5 pt-5 border-top">
        <div class="col-12">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-book fa-3x text-primary mb-3"></i>
                    </div>
                    <h4>Wide Selection</h4>
                    <p class="text-muted">Thousands of books from various genres</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    </div>
                    <h4>Fast Delivery</h4>
                    <p class="text-muted">Free shipping on orders over $25</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-undo-alt fa-3x text-primary mb-3"></i>
                    </div>
                    <h4>Easy Returns</h4>
                    <p class="text-muted">30-day return policy for all books</p>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="feature-icon">
                        <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    </div>
                    <h4>24/7 Support</h4>
                    <p class="text-muted">We're here to help you anytime</p>
                </div>
            </div>
        </div>
    </div>
</div>

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

.empty-state-icon {
    opacity: 0.7;
}

.feature-icon {
    transition: transform 0.3s ease;
}

.feature-icon:hover {
    transform: scale(1.1);
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.book-meta .badge {
    font-size: 0.7rem;
}
</style>
@endsection