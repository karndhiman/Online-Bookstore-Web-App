<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->with(['orderItems.book'])
                      ->latest()
                      ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
                     ->with(['orderItems.book', 'user'])
                     ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string'
        ]);

        $book = Book::where('status', 'available')
                   ->where('quantity', '>=', $request->quantity)
                   ->findOrFail($request->book_id);

        // Calculate total
        $totalAmount = $book->price * $request->quantity;

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'shipping_address' => $request->shipping_address,
            'status' => 'pending'
        ]);

        // Create order item
        OrderItem::create([
            'order_id' => $order->id,
            'book_id' => $book->id,
            'quantity' => $request->quantity,
            'price' => $book->price
        ]);

        // Update book quantity and status
        $book->decrement('quantity', $request->quantity);
        
        if ($book->quantity === 0) {
            $book->update(['status' => 'sold']);
        }

        return redirect()->route('orders.index')
            ->with('success', 'Order placed successfully! Your order number is ' . $order->order_number);
    }
}