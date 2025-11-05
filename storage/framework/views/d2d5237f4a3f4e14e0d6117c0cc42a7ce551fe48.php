

<?php $__env->startSection('title', 'Checkout - Online BookStore'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="row align-items-center mb-3">
                        <div class="col-2">
                            <img src="<?php echo e($book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/60x80/4A6572/FFFFFF?text=No+Image'); ?>" 
                                 alt="Book Cover" class="img-fluid rounded">
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1"><?php echo e($book->title); ?></h6>
                            <p class="text-muted mb-0">by <?php echo e($book->author); ?></p>
                            <small class="text-muted">Qty: <?php echo e($book->cart_quantity); ?></small>
                        </div>
                        <div class="col-4 text-end">
                            <strong>$<?php echo e(number_format($book->price * $book->cart_quantity, 2)); ?></strong>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <hr>
                    <div class="row">
                        <div class="col-8">
                            <p class="mb-1">Subtotal:</p>
                            <p class="mb-1">Shipping:</p>
                            <p class="mb-1">Tax (8%):</p>
                            <hr>
                            <p class="h5 mb-0">Total:</p>
                        </div>
                        <div class="col-4 text-end">
                            <p class="mb-1">$<?php echo e(number_format($subtotal, 2)); ?></p>
                            <p class="mb-1">$<?php echo e(number_format($shipping, 2)); ?></p>
                            <p class="mb-1">$<?php echo e(number_format($tax, 2)); ?></p>
                            <hr>
                            <p class="h5 mb-0">$<?php echo e(number_format($total, 2)); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Shipping & Payment Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('checkout.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Shipping Information -->
                        <div class="mb-4">
                            <h6 class="mb-3">Shipping Address</h6>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Full Address *</label>
                                <textarea class="form-control <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="shipping_address" name="shipping_address" rows="3" required
                                          placeholder="Enter your complete shipping address"><?php echo e(old('shipping_address', Auth::user()->address ?? '')); ?></textarea>
                                <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                            <h6 class="mb-3">Payment Method</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="card" value="card" checked>
                                <label class="form-check-label" for="card">
                                    <i class="fas fa-credit-card me-2"></i> Credit/Debit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="cod" value="cod">
                                <label class="form-check-label" for="cod">
                                    <i class="fas fa-money-bill-wave me-2"></i> Cash on Delivery
                                </label>
                            </div>
                        </div>

                        <!-- Card Details (shown when card is selected) -->
                        <div id="card-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="card_number" class="form-label">Card Number *</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['card_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="card_number" name="card_number" 
                                               placeholder="1234 5678 9012 3456"
                                               value="<?php echo e(old('card_number')); ?>">
                                        <?php $__errorArgs = ['card_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="expiry_date" class="form-label">Expiry Date *</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="expiry_date" name="expiry_date" 
                                               placeholder="MM/YY"
                                               value="<?php echo e(old('expiry_date')); ?>">
                                        <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV *</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['cvv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="cvv" name="cvv" 
                                               placeholder="123"
                                               value="<?php echo e(old('cvv')); ?>">
                                        <?php $__errorArgs = ['cvv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i> Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Security -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Secure Checkout</h5>
                    <p class="text-muted small">Your payment information is encrypted and secure.</p>
                </div>
            </div>

            <!-- Support -->
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">Need Help?</h6>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-phone text-primary me-3"></i>
                        <div>
                            <small class="text-muted">Call us at</small>
                            <p class="mb-0">+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope text-primary me-3"></i>
                        <div>
                            <small class="text-muted">Email us at</small>
                            <p class="mb-0">support@bookstore.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cardDetails = document.getElementById('card-details');
    const cardRadio = document.getElementById('card');
    const codRadio = document.getElementById('cod');

    function toggleCardDetails() {
        if (cardRadio.checked) {
            cardDetails.style.display = 'block';
        } else {
            cardDetails.style.display = 'none';
        }
    }

    cardRadio.addEventListener('change', toggleCardDetails);
    codRadio.addEventListener('change', toggleCardDetails);

    // Initialize on page load
    toggleCardDetails();
});
</script>

<style>
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid #dee2e6;
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0a58ca);
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0a58ca, #084298);
    transform: translateY(-1px);
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kumar\OneDrive - Chandigarh University\Desktop\lerval\Book\resources\views/checkout.blade.php ENDPATH**/ ?>