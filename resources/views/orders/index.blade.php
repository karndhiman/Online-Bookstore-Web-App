@extends('layouts.app')

@section('title', 'My Orders - Online BookStore')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Orders</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Sample Orders Data -->
    @php
        $orders = [
            [
                'id' => 1001,
                'date' => now()->subDays(2)->format('M j, Y'),
                'status' => 'delivered',
                'status_color' => 'success',
                'total' => 89.97,
                'items' => [
                    ['title' => 'Sample Book 1', 'quantity' => 1, 'price' => 29.99],
                    ['title' => 'Sample Book 2', 'quantity' => 2, 'price' => 29.99],
                ]
            ],
            [
                'id' => 1002,
                'date' => now()->subDays(5)->format('M j, Y'),
                'status' => 'shipped',
                'status_color' => 'info',
                'total' => 45.98,
                'items' => [
                    ['title' => 'Sample Book 3', 'quantity' => 1, 'price' => 24.99],
                    ['title' => 'Sample Book 4', 'quantity' => 1, 'price' => 20.99],
                ]
            ],
            [
                'id' => 1003,
                'date' => now()->subDays(10)->format('M j, Y'),
                'status' => 'processing',
                'status_color' => 'warning',
                'total' => 34.99,
                'items' => [
                    ['title' => 'Sample Book 5', 'quantity' => 1, 'price' => 34.99],
                ]
            ],
        ];
    @endphp

    @if(count($orders) > 0)
        <div class="row">
            <div class="col-12">
                @foreach($orders as $order)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-0">Order #{{ $order['id'] }}</h5>
                                <small class="text-muted">Placed on {{ $order['date'] }}</small>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <span class="badge bg-{{ $order['status_color'] }} text-capitalize">
                                    {{ $order['status'] }}
                                </span>
                                <strong class="ms-2">Total: ${{ number_format($order['total'], 2) }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($order['items'] as $item)
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item['title'] }}</h6>
                                <p class="text-muted mb-0">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <span>${{ number_format($item['price'], 2) }} each</span>
                            </div>
                            <div class="col-md-3 text-end">
                                <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="row mt-3">
                            <div class="col-md-8">
                                <div class="progress mb-2" style="height: 8px;">
                                    @if($order['status'] === 'delivered')
                                    <div class="progress-bar bg-success" style="width: 100%"></div>
                                    @elseif($order['status'] === 'shipped')
                                    <div class="progress-bar bg-info" style="width: 75%"></div>
                                    @elseif($order['status'] === 'processing')
                                    <div class="progress-bar bg-warning" style="width: 50%"></div>
                                    @else
                                    <div class="progress-bar bg-secondary" style="width: 25%"></div>
                                    @endif
                                </div>
                                <small class="text-muted">
                                    @if($order['status'] === 'delivered')
                                        Delivered on {{ now()->subDays(1)->format('M j, Y') }}
                                    @elseif($order['status'] === 'shipped')
                                        Expected delivery: {{ now()->addDays(3)->format('M j, Y') }}
                                    @elseif($order['status'] === 'processing')
                                        Preparing your order
                                    @else
                                        Order received
                                    @endif
                                </small>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('orders.show', $order['id']) }}" class="btn btn-outline-primary btn-sm">
                                    View Details
                                </a>
                                @if($order['status'] === 'delivered')
                                <button class="btn btn-outline-secondary btn-sm">
                                    Track Package
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h3>No Orders Yet</h3>
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="{{ route('books.index') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection