<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_borrowings' => Borrowing::count(),
            'active_borrowings' => Borrowing::where('status', 'borrowed')->count(),
            'overdue_borrowings' => Borrowing::where('status', 'overdue')->count(),
            'total_categories' => Category::count(),
        ];

        $recent_borrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_borrowings'));
    }
}