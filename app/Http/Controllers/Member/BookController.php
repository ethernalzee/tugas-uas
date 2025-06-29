<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->where('available_stock', '>', 0);

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('member.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        return view('member.books.show', compact('book'));
    }

    public function borrow(Book $book)
    {
        $user = auth::user();

        // Check if user has overdue books
        $overdueBorrowings = $user->borrowings()
            ->where('status', 'overdue')
            ->count();

        if ($overdueBorrowings > 0) {
            return redirect()->back()
                ->with('error', 'Anda memiliki buku yang terlambat dikembalikan. Harap kembalikan terlebih dahulu.');
        }

        // Check if user has reached borrowing limit (max 3 books)
        $activeBorrowings = $user->activeBorrowings()->count();
        if ($activeBorrowings >= 3) {
            return redirect()->back()
                ->with('error', 'Anda sudah mencapai batas maksimal peminjaman (3 buku).');
        }

        // Check if book is available
        if (!$book->isAvailable()) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Check if user already borrowed this book
        $alreadyBorrowed = $user->borrowings()
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($alreadyBorrowed) {
            return redirect()->back()
                ->with('error', 'Anda sudah meminjam buku ini.');
        }

        // Create borrowing record
        Borrowing::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrowed_at' => Carbon::now(),
            'due_date' => Carbon::now()->addDays(14), // 2 weeks
            'status' => 'borrowed',
        ]);

        // Update book available stock
        $book->available_stock -= 1;
        $book->save();

        return redirect()->route('member.books.index')
            ->with('success', 'Buku berhasil dipinjam. Harap kembalikan sebelum ' . Carbon::now()->addDays(14)->format('d/m/Y'));
    }
}