<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $books = [];
        $subtotal = 0;
        $shipping = 5.00;
        $taxRate = 0.08;

        foreach ($cartItems as $bookId => $item) {
            $book = Book::find($bookId);
            if ($book && $book->isAvailable()) {
                $book->cart_quantity = $item['quantity'];
                $books[] = $book;
                $subtotal += $book->price * $item['quantity'];
            }
        }

        $tax = $subtotal * $taxRate;
        $total = $subtotal + $shipping + $tax;

        return view('checkout', compact('books', 'total', 'subtotal', 'shipping', 'tax'));
    }

    public function store(Request $request)
    {
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:card,cod',
            'card_number' => 'required_if:payment_method,card',
            'expiry_date' => 'required_if:payment_method,card',
            'cvv' => 'required_if:payment_method,card',
        ]);

        // Calculate total
        $subtotal = 0;
        $shipping = 5.00;
        $taxRate = 0.08;

        foreach ($cartItems as $bookId => $item) {
            $book = Book::find($bookId);
            if ($book) {
                $subtotal += $book->price * $item['quantity'];
            }
        }

        $tax = $subtotal * $taxRate;
        $totalAmount = $subtotal + $shipping + $tax;

        try {
            // Start transaction
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'status' => $request->payment_method === 'cod' ? 'pending' : 'processing'
            ]);

            $soldBooks = [];

            // Create order items and update book quantities
            foreach ($cartItems as $bookId => $item) {
                $book = Book::find($bookId);
                
                if ($book && $book->isAvailable()) {
                    // Check if requested quantity is available
                    if ($item['quantity'] > $book->quantity) {
                        throw new \Exception("Requested quantity for {$book->title} is not available. Only {$book->quantity} left in stock.");
                    }

                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $book->id,
                        'quantity' => $item['quantity'],
                        'price' => $book->price
                    ]);

                    // Update book quantity
                    $book->decrement('quantity', $item['quantity']);
                    
                    // Mark as sold if quantity reaches zero
                    if ($book->quantity === 0) {
                        $book->update(['status' => 'sold']);
                        $soldBooks[] = $book->title;
                    }

                    // Add to sold books list for message
                    $soldBooks[] = "{$book->title} (Qty: {$item['quantity']})";
                }
            }

            // Commit transaction
            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Prepare success message
            $successMessage = 'Order placed successfully! Your order number is ' . $order->order_number;
            
            if (!empty($soldBooks)) {
                $successMessage .= '. Books purchased: ' . implode(', ', $soldBooks);
            }

            return redirect()->route('orders.show', $order->id)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            
            return redirect()->route('cart')
                ->with('error', 'Order failed: ' . $e->getMessage());
        }
    }

    public function confirmPurchase($orderId)
    {
        $order = Order::where('user_id', Auth::id())
                     ->with(['orderItems.book'])
                     ->findOrFail($orderId);

        return view('checkout.confirm', compact('order'));
    }
}