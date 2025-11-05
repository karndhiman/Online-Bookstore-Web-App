

<?php $__env->startSection('title', 'Browse Books - Online BookStore'); ?>

<?php $__env->startSection('content'); ?>
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
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Books Count and Filter Info -->
    <div class="row mb-4">
        <div class="col">
            <p class="text-muted mb-0">Showing <?php echo e($books->count()); ?> books</p>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card book-card h-100 shadow-sm">
                <div class="position-relative">
                    <img src="<?php echo e($book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/300x400/4A6572/FFFFFF?text=No+Image'); ?>" 
                         class="card-img-top" alt="Book Cover" style="height: 300px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-<?php echo e($book->isAvailable() ? 'success' : 'danger'); ?>">
                            <?php echo e($book->isAvailable() ? 'Available' : 'Sold'); ?>

                        </span>
                    </div>
                    <?php if($book->condition == 'new'): ?>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-star me-1"></i> New
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-dark"><?php echo e(Str::limit($book->title, 50)); ?></h5>
                    <p class="card-text text-muted mb-2">by <?php echo e($book->author); ?></p>
                    
                    <div class="book-meta mb-3">
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-bookmark me-1 text-primary"></i><?php echo e($book->genre); ?>

                            </span>
                            <span class="badge bg-light text-dark border">
                                <i class="fas fa-certificate me-1 text-info"></i><?php echo e(ucfirst($book->condition)); ?>

                            </span>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h4 text-success mb-0">$<?php echo e(number_format($book->price, 2)); ?></span>
                            <div class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="<?php echo e(route('books.show', $book->id)); ?>" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                            
                            <?php if($book->isAvailable()): ?>
                            <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                </button>
                            </form>
                            <?php else: ?>
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="fas fa-times me-1"></i> Out of Stock
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <!-- Empty State -->
        <div class="col-12">
            <div class="text-center py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-book-open fa-4x text-muted"></i>
                </div>
                <h3 class="text-muted">No Books Available</h3>
                <p class="text-muted mb-4">We couldn't find any books matching your criteria.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-redo me-1"></i> Reset Filters
                    </a>
                    <a href="<?php echo e(route('sell')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Sell Your Book
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($books->hasPages()): ?>
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Books pagination">
                <ul class="pagination justify-content-center">
                    
                    <?php if($books->onFirstPage()): ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </span>
                    </li>
                    <?php else: ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($books->previousPageUrl()); ?>">
                            <i class="fas fa-chevron-left me-1"></i> Previous
                        </a>
                    </li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $books->getUrlRange(1, $books->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="page-item <?php echo e($page == $books->currentPage() ? 'active' : ''); ?>">
                        <a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($books->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($books->nextPageUrl()); ?>">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link">
                            Next <i class="fas fa-chevron-right ms-1"></i>
                        </span>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kumar\OneDrive - Chandigarh University\Desktop\lerval\Book\resources\views/books/index.blade.php ENDPATH**/ ?>