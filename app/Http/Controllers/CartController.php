<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $books = [];
        $total = 0;
        $subtotal = 0;
        $shipping = 5.00; // Fixed shipping cost
        $taxRate = 0.08; // 8% tax

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

        return view('cart', compact('books', 'total', 'subtotal', 'shipping', 'tax'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', 'This book is no longer available.');
        }

        if ($request->quantity > $book->quantity) {
            return redirect()->back()->with('error', 'Requested quantity not available. Only ' . $book->quantity . ' left in stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            $newQuantity = $cart[$book->id]['quantity'] + $request->quantity;
            if ($newQuantity > $book->quantity) {
                return redirect()->back()->with('error', 'Cannot add more. Only ' . $book->quantity . ' left in stock.');
            }
            $cart[$book->id]['quantity'] = $newQuantity;
        } else {
            $cart[$book->id] = [
                'quantity' => $request->quantity,
                'title' => $book->title,
                'price' => $book->price,
                'author' => $book->author,
                'cover_image' => $book->cover_image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Book added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($request->book_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$request->book_id])) {
            if ($request->quantity > $book->quantity) {
                return redirect()->back()->with('error', 'Requested quantity not available. Only ' . $book->quantity . ' left in stock.');
            }
            $cart[$request->book_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$request->book_id])) {
            unset($cart[$request->book_id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Book removed from cart!');
        }

        return redirect()->back()->with('error', 'Book not found in cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart')->with('success', 'Cart cleared successfully!');
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return $count;
    }
}