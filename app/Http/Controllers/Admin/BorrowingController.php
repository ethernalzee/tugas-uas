<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $borrowings = $query->latest()->paginate(10);

        // Update status overdue
        $this->updateOverdueStatus();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function show(Borrowing $borrowing)
    {
        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan');
        }

        $borrowing->returned_at = Carbon::now();
        $borrowing->status = 'returned';
        
        // Calculate fine if overdue
        if (Carbon::now()->gt($borrowing->due_date)) {
            $daysOverdue = Carbon::now()->diffInDays($borrowing->due_date);
            $borrowing->fine = $daysOverdue * 1000; // Rp 1000 per hari
        }

        $borrowing->save();

        // Update book available stock
        $book = $borrowing->book;
        $book->available_stock += 1;
        $book->save();

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    private function updateOverdueStatus()
    {
        Borrowing::where('status', 'borrowed')
            ->where('due_date', '<', Carbon::now())
            ->update(['status' => 'overdue']);
    }
}