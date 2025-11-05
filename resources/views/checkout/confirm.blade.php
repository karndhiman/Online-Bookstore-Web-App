@extends('layouts.app')

@section('title', 'Order Confirmation - Online BookStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                    <h2 class="mb-0">Order Confirmed!</h2>
                    <p class="mb-0">Thank you for your purchase</p>
                </div>
                
                <div class="card-body p-5">
                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Order Details</h5>
                            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($order->status) }}</span></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Shipping Address</h5>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                    </div>

                    <!-- Purchased Books -->
                    <div class="mb-4">
                        <h5>Purchased Books</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Book</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->book->cover_image ? asset($item->book->cover_image) : 'https://via.placeholder.com/60x80/4A6572/FFFFFF?text=No+Image' }}" 
                                                     alt="{{ $item->book->title }}" 
                                                     class="img-thumbnail me-3" style="width: 60px; height: 80px; object-fit: cover;">
                                                <div>
                                                    <strong>{{ $item->book->title }}</strong><br>
                                                    <small class="text-muted">by {{ $item->book->author }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $item->book->isAvailable() ? 'success' : 'danger' }}">
                                                {{ $item->book->isAvailable() ? 'Available' : 'Sold Out' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td colspan="2"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>What happens next?</h6>
                        <ul class="mb-0">
                            <li>You will receive an email confirmation shortly</li>
                            <li>Your books will be prepared for shipping</li>
                            <li>You can track your order in "My Orders" section</li>
                            <li>Books marked as "Sold Out" are no longer available for purchase</li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('orders.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-box me-2"></i>View My Orders
                        </a>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.img-thumbnail {
    border-radius: 8px;
}
</style>
@endsection