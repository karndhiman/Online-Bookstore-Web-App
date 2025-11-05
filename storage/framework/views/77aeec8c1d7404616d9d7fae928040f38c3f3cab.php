

<?php $__env->startSection('title', 'Shopping Cart - Online BookStore'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4">Shopping Cart</h1>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(count($books) > 0): ?>
        <div class="row">
            <div class="col-lg-8">
                <!-- Cart Items -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Cart Items (<?php echo e(count($books)); ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row align-items-center mb-4 pb-4 border-bottom">
                            <div class="col-md-2">
                                <img src="<?php echo e($book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/80x100/4A6572/FFFFFF?text=No+Image'); ?>" 
                                     alt="Book Cover" class="img-fluid rounded shadow">
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-1"><?php echo e($book->title); ?></h5>
                                <p class="text-muted mb-1">by <?php echo e($book->author); ?></p>
                                <p class="text-success mb-0">$<?php echo e(number_format($book->price, 2)); ?></p>
                            </div>
                            <div class="col-md-3">
                                <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="d-flex align-items-center">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                                    <label class="me-2">Qty:</label>
                                    <input type="number" class="form-control form-control-sm" 
                                           name="quantity" value="<?php echo e($book->cart_quantity); ?>" 
                                           min="1" max="<?php echo e($book->quantity); ?>" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </form>
                                <small class="text-muted">Max: <?php echo e($book->quantity); ?> available</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <strong>$<?php echo e(number_format($book->price * $book->cart_quantity, 2)); ?></strong>
                            </div>
                            <div class="col-md-1 text-end">
                                <form action="<?php echo e(route('cart.remove')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="text-end">
                            <form action="<?php echo e(route('cart.clear')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="fas fa-trash-alt me-1"></i> Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (<?php echo e(count($books)); ?> items):</span>
                            <span>$<?php echo e(number_format($subtotal, 2)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>$<?php echo e(number_format($shipping, 2)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Tax (8%):</span>
                            <span>$<?php echo e(number_format($tax, 2)); ?></span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>$<?php echo e(number_format($total, 2)); ?></strong>
                        </div>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('checkout')); ?>" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-lock me-1"></i> Proceed to Checkout
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-sign-in-alt me-1"></i> Login to Checkout
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('books.index')); ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-shopping-bag me-1"></i> Continue Shopping
                        </a>
                    </div>
                </div>

                <!-- Security Features -->
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-4">
                                <i class="fas fa-shield-alt text-primary fa-2x mb-2"></i>
                                <p class="small mb-0">Secure Payment</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-truck text-primary fa-2x mb-2"></i>
                                <p class="small mb-0">Free Shipping</p>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-undo-alt text-primary fa-2x mb-2"></i>
                                <p class="small mb-0">Easy Returns</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty Cart State -->
        <div class="text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
            </div>
            <h3 class="text-muted">Your cart is empty</h3>
            <p class="text-muted mb-4">Start adding some books to your cart!</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="<?php echo e(route('books.index')); ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-book me-1"></i> Browse Books
                </a>
                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-home me-1"></i> Go Home
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.empty-cart-icon {
    opacity: 0.7;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid #dee2e6;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0a58ca);
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0a58ca, #084298);
    transform: translateY(-1px);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kumar\OneDrive - Chandigarh University\Desktop\lerval\Book\resources\views/cart.blade.php ENDPATH**/ ?>