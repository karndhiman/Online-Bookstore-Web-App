<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="fas fa-book"></i> BookStore
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('books.index') }}">Browse Books</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sell') }}">Sell Books</a>
                </li>
            </ul>

            <!-- Search Form -->
            <form class="d-flex me-3" action="{{ route('books.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Search books..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>

            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="badge bg-primary cart-count">
                                @php
                                    $cartCount = 0;
                                    $cart = session()->get('cart', []);
                                    foreach ($cart as $item) {
                                        $cartCount += $item['quantity'];
                                    }
                                @endphp
                                {{ $cartCount }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fas fa-box"></i> Orders
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                <i class="fas fa-user me-2"></i>Profile
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                <i class="fas fa-box me-2"></i>My Orders
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Add this script to update cart count dynamically -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to update cart count
    function updateCartCount() {
        fetch('{{ route("cart") }}')
            .then(response => response.text())
            .then(html => {
                // This is a simple approach - for real-time updates you'd need AJAX
                // For now, we'll rely on page refreshes to update the count
            });
    }

    // Update cart count when items are added (you can enhance this with AJAX later)
    const cartForms = document.querySelectorAll('form[action*="cart.add"]');
    cartForms.forEach(form => {
        form.addEventListener('submit', function() {
            // The count will update after page refresh from form submission
        });
    });
});
</script>

<style>
.cart-count {
    font-size: 0.7rem;
    margin-left: 2px;
}

.navbar-nav .nav-link {
    transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
    color: #fff !important;
}

.dropdown-menu {
    border: none;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.dropdown-item {
    padding: 8px 16px;
    transition: background-color 0.3s ease;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.5rem;
}
</style>