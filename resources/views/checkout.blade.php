@extends('layouts.app')

@section('title', 'Checkout - Online BookStore')

@section('content')
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
                    @foreach($books as $book)
                    <div class="row align-items-center mb-3">
                        <div class="col-2">
                            <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : 'https://via.placeholder.com/60x80/4A6572/FFFFFF?text=No+Image' }}" 
                                 alt="Book Cover" class="img-fluid rounded">
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1">{{ $book->title }}</h6>
                            <p class="text-muted mb-0">by {{ $book->author }}</p>
                            <small class="text-muted">Qty: {{ $book->cart_quantity }}</small>
                        </div>
                        <div class="col-4 text-end">
                            <strong>${{ number_format($book->price * $book->cart_quantity, 2) }}</strong>
                        </div>
                    </div>
                    @endforeach

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
                            <p class="mb-1">${{ number_format($subtotal, 2) }}</p>
                            <p class="mb-1">${{ number_format($shipping, 2) }}</p>
                            <p class="mb-1">${{ number_format($tax, 2) }}</p>
                            <hr>
                            <p class="h5 mb-0">${{ number_format($total, 2) }}</p>
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
                    <form method="POST" action="{{ route('checkout.store') }}">
                        @csrf

                        <!-- Shipping Information -->
                        <div class="mb-4">
                            <h6 class="mb-3">Shipping Address</h6>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Full Address *</label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                          id="shipping_address" name="shipping_address" rows="3" required
                                          placeholder="Enter your complete shipping address">{{ old('shipping_address', Auth::user()->address ?? '') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                        <input type="text" class="form-control @error('card_number') is-invalid @enderror" 
                                               id="card_number" name="card_number" 
                                               placeholder="1234 5678 9012 3456"
                                               value="{{ old('card_number') }}">
                                        @error('card_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="expiry_date" class="form-label">Expiry Date *</label>
                                        <input type="text" class="form-control @error('expiry_date') is-invalid @enderror" 
                                               id="expiry_date" name="expiry_date" 
                                               placeholder="MM/YY"
                                               value="{{ old('expiry_date') }}">
                                        @error('expiry_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV *</label>
                                        <input type="text" class="form-control @error('cvv') is-invalid @enderror" 
                                               id="cvv" name="cvv" 
                                               placeholder="123"
                                               value="{{ old('cvv') }}">
                                        @error('cvv')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
@endsection