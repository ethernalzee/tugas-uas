@extends('layouts.app')

@section('title', 'My Borrowings')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="bi bi-journal-bookmark me-2"></i>My Borrowings</h1>
                <a href="{{ route('member.books.index') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Borrow More Books
                </a>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('member.borrowings.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="{{ route('member.borrowings.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrowings List -->
    <div class="row">
        <div class="col-md-12">
            @if($borrowings->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Book</th>
                                        <th>Author</th>
                                        <th>Borrowed Date</th>
                                        <th>Due Date</th>
                                        <th>Returned Date</th>
                                        <th>Status</th>
                                        <th>Fine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowings as $borrowing)
                                        <tr class="{{ $borrowing->status == 'overdue' ? 'table-danger' : '' }}">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($borrowing->book->image)
                                                        <img src="{{ asset('storage/' . $borrowing->book->image) }}" 
                                                             class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="bi bi-book text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <strong>{{ $borrowing->book->title }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $borrowing->book->isbn }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $borrowing->book->author }}</td>
                                            <td>{{ $borrowing->borrowed_at->format('d/m/Y') }}</td>
                                            <td>
                                                {{ $borrowing->due_date->format('d/m/Y') }}
                                                @if($borrowing->status == 'borrowed' && $borrowing->due_date->isPast())
                                                    <br><small class="text-danger">
                                                        ({{ $borrowing->due_date->diffForHumans() }})
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($borrowing->returned_at)
                                                    {{ $borrowing->returned_at->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($borrowing->status == 'borrowed')
                                                    <span class="badge bg-primary">Borrowed</span>
                                                @elseif($borrowing->status == 'returned')
                                                    <span class="badge bg-success">Returned</span>
                                                @else
                                                    <span class="badge bg-danger">Overdue</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($borrowing->fine > 0)
                                                    <span class="text-danger fw-bold">
                                                        Rp {{ number_format($borrowing->fine, 0, ',', '.') }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if($borrowings->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $borrowings->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-journal-x text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">No Borrowing Records</h4>
                        <p class="text-muted">You haven't borrowed any books yet.</p>
                        <a href="{{ route('member.books.index') }}" class="btn btn-primary">
                            <i class="bi bi-book me-1"></i>Browse Books
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Cards (if there are borrowings) -->
    @if($borrowings->count() > 0)
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5>Active Borrowings</h5>
                        <h2>{{ auth()->user()->activeBorrowings()->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h5>Overdue Books</h5>
                        <h2>{{ auth()->user()->borrowings()->where('status', 'overdue')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5>Total Fines</h5>
                        <h2>Rp {{ number_format(auth()->user()->borrowings()->sum('fine'), 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection