<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::where('status', 'available')
                    ->where('quantity', '>', 0)
                    ->with('user')
                    ->latest()
                    ->paginate(12);

        return view('books.index', compact('books'));
    }

    public function show($id)
    {
        $book = Book::with('user')->findOrFail($id);
        return view('books.show', compact('book'));
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $results = Book::where('status', 'available')
                      ->where('quantity', '>', 0)
                      ->where(function($q) use ($query) {
                          $q->where('title', 'LIKE', "%{$query}%")
                            ->orWhere('author', 'LIKE', "%{$query}%")
                            ->orWhere('genre', 'LIKE', "%{$query}%");
                      })
                      ->with('user')
                      ->latest()
                      ->paginate(12);

        return view('books.search', compact('query', 'results'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'genre' => 'required|string',
            'description' => 'required|string',
            'condition' => 'required|string|in:new,like-new,very-good,good,acceptable',
            'price' => 'required|numeric|min:1|max:1000',
            'quantity' => 'required|integer|min:1|max:100',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Handle image upload
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('book_covers', 'public');
        }

        // Create book
        Book::create([
            'title' => $validated['title'],
            'author' => $validated['author'],
            'isbn' => $validated['isbn'],
            'genre' => $validated['genre'],
            'description' => $validated['description'],
            'condition' => $validated['condition'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'cover_image' => $coverImagePath,
            'user_id' => Auth::id(),
            'status' => 'available'
        ]);

        return redirect()->route('books.index')
            ->with('success', 'Your book "' . $validated['title'] . '" has been listed successfully!');
    }
}