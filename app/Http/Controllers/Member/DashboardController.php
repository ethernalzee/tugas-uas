<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth::user();
        
        $stats = [
            'active_borrowings' => $user->activeBorrowings()->count(),
            'total_borrowings' => $user->borrowings()->count(),
            'overdue_borrowings' => $user->borrowings()->where('status', 'overdue')->count(),
        ];

        $recent_borrowings = $user->borrowings()
            ->with('book')
            ->latest()
            ->take(5)
            ->get();

        $available_books = Book::where('available_stock', '>', 0)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();

        return view('member.dashboard', compact('stats', 'recent_borrowings', 'available_books'));
    }
}