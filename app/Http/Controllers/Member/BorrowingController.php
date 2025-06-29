<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $user = auth::user();
        $query = $user->borrowings()->with('book');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $borrowings = $query->latest()->paginate(10);

        return view('member.borrowings.index', compact('borrowings'));
    }
}