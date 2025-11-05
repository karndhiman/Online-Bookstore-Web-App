<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured books (latest 6 available books)
        $featuredBooks = Book::where('status', 'available')
                            ->where('quantity', '>', 0)
                            ->with('user')
                            ->latest()
                            ->take(6)
                            ->get();

        // Get statistics
        $totalBooks = Book::where('status', 'available')->where('quantity', '>', 0)->count();
        $totalGenres = Book::distinct('genre')->count('genre');
        $totalAuthors = Book::distinct('author')->count('author');
        $soldBooks = Book::where('status', 'sold')->count();

        return view('home', compact(
            'featuredBooks',
            'totalBooks',
            'totalGenres',
            'totalAuthors',
            'soldBooks'
        ));
    }

    public function profile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only('name', 'email'));

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }
}