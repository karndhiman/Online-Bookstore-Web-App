

<?php $__env->startSection('title', 'My Profile - Online BookStore'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Sidebar -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px;">
                            <span class="text-white fw-bold fs-2"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
                        </div>
                    </div>
                    <h4><?php echo e(Auth::user()->name); ?></h4>
                    <p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
                    <p class="text-muted">Member since <?php echo e(Auth::user()->created_at->format('F Y')); ?></p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Account Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Orders:</span>
                        <strong>3</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Books Purchased:</span>
                        <strong>5</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Books Sold:</span>
                        <strong>2</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Member Since:</span>
                        <strong><?php echo e(Auth::user()->created_at->format('M Y')); ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Profile Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo e(Auth::user()->name); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo e(Auth::user()->email); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   placeholder="+1 (555) 123-4567">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Enter your address"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="zip_code" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="ZIP Code">
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-shopping-cart text-primary me-2"></i>
                                <span>Placed new order #1004</span>
                            </div>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-book text-success me-2"></i>
                                <span>Added "The Great Novel" to wishlist</span>
                            </div>
                            <small class="text-muted">1 day ago</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-star text-warning me-2"></i>
                                <span>Rated "Programming Basics" 5 stars</span>
                            </div>
                            <small class="text-muted">3 days ago</small>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-truck text-info me-2"></i>
                                <span>Order #1003 delivered</span>
                            </div>
                            <small class="text-muted">1 week ago</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('password.update')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kumar\OneDrive - Chandigarh University\Desktop\lerval\Book\resources\views/profile.blade.php ENDPATH**/ ?>