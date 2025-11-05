@extends('layouts.app')

@section('title', 'Order Details - Online BookStore')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
            <li class="breadcrumb-item active">Order #{{ $id }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">Order #{{ $id }}</h4>
                    <small class="text-muted">Placed on {{ now()->subDays(2)->format('F j, Y \\a\\t g:i A') }}</small>
                </div>
                <div class="card-body">
                    <!-- Order Items -->
                    <h5 class="mb-3">Items in Your Order</h5>
                    @php
                        $orderItems = [
                            ['title' => 'Sample Book 1', 'author' => 'Author 1', 'quantity' => 1, 'price' => 29.99],
                            ['title' => 'Sample Book 2', 'author' => 'Author 2', 'quantity' => 2, 'price' => 29.99],
                        ];
                        $subtotal = 89.97;
                        $shipping = 5.00;
                        $tax = 7.19;
                        $total = 102.16;
                    @endphp

                    @foreach($orderItems as $item)
                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                        <div class="col-2">
                            <img src="https://via.placeholder.com/60x80/4A6572/FFFFFF?text=B{{ $id }}" 
                                 class="img-fluid rounded" alt="Book Cover">
                        </div>
                        <div class="col-6">
                            <h6 class="mb-1">{{ $item['title'] }}</h6>
                            <p class="text-muted mb-0">by {{ $item['author'] }}</p>
                            <small class="text-muted">Quantity: {{ $item['quantity'] }}</small>
                        </div>
                        <div class="col-4 text-end">
                            <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                        </div>
                    </div>
                    @endforeach

                    <!-- Order Total -->
                    <div class="row mt-4">
                        <div class="col-8">
                            <p class="mb-1">Subtotal:</p>
                            <p class="mb-1">Shipping:</p>
                            <p class="mb-1">Tax:</p>
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

            <!-- Shipping Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Sunny</strong></p>
                    <p class="mb-1">123 Main Street</p>
                    <p class="mb-1">Apt 4B</p>
                    <p class="mb-1">New York, NY 10001</p>
                    <p class="mb-0">United States</p>
                    <p class="mb-0 mt-2"><strong>Phone:</strong> (555) 123-4567</p>
                    <p class="mb-0"><strong>Email:</strong> Sunny@gmail.com</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <span class="badge bg-success fs-6 text-capitalize mb-3">Delivered</span>
                        <p class="text-muted">Delivered on {{ now()->subDays(1)->format('F j, Y') }}</p>
                    </div>

                    <!-- Tracking Timeline -->
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Order Placed</h6>
                                <small class="text-muted">{{ now()->subDays(2)->format('M j, g:i A') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Processing</h6>
                                <small class="text-muted">{{ now()->subDays(2)->format('M j, g:i A') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Shipped</h6>
                                <small class="text-muted">{{ now()->subDays(1)->format('M j, g:i A') }}</small>
                            </div>
                        </div>
                        <div class="timeline-item completed">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Delivered</h6>
                                <small class="text-muted">{{ now()->subDays(1)->format('M j, g:i A') }}</small>
                            </div>
                        </div>
                    </div>

                    <style>
                        .timeline {
                            position: relative;
                            padding-left: 30px;
                        }
                        .timeline-item {
                            position: relative;
                            margin-bottom: 20px;
                        }
                        .timeline-marker {
                            position: absolute;
                            left: -30px;
                            top: 0;
                            width: 20px;
                            height: 20px;
                            border-radius: 50%;
                            border: 3px solid white;
                        }
                        .timeline-item.completed .timeline-marker {
                            background: #28a745;
                        }
                        .timeline-content {
                            padding-left: 10px;
                        }
                    </style>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-shipping-fast"></i> Track Package
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-undo-alt"></i> Return Items
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection