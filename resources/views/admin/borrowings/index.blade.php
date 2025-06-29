@extends('layouts.app')

@section('title', 'Manage Borrowings')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-journal-bookmark me-2"></i>Manage Borrowings</h1>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.borrowings.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed
                                </option>
                                <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned
                                </option>
                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search by member name or book title..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if($borrowings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Book</th>
                                    <th>Borrowed Date</th>
                                    <th>Due Date</th>
                                    <th>Returned Date</th>
                                    <th>Status</th>
                                    <th>Fine</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowings as $borrowing)
                                    <tr class="{{ $borrowing->status == 'overdue' ? 'table-warning' : '' }}">
                                        <td>
                                            <strong>{{ $borrowing->user->name }}</strong><br>
                                            <small class="text-muted">{{ $borrowing->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $borrowing->book->title }}</strong><br>
                                            <small class="text-muted">by {{ $borrowing->book->author }}</small>
                                        </td>
                                        <td>{{ $borrowing->borrowed_at->format('d/m/Y') }}</td>
                                        <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $borrowing->returned_at ? $borrowing->returned_at->format('d/m/Y') : '-' }}
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
                                                <span class="text-danger fw-bold">Rp {{ number_format($borrowing->fine) }}</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.borrowings.show', $borrowing) }}"
                                                    class="btn btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                @if($borrowing->status == 'borrowed' || $borrowing->status == 'overdue')
                                                    <form action="{{ route('admin.borrowings.return', $borrowing) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-success"
                                                            onclick="return confirm('Mark this book as returned?')">
                                                            <i class="bi bi-check-circle"></i> Return
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $borrowings->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-journal-bookmark display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No borrowings found</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection