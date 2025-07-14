@extends('layouts.app')

@section('title', 'Borrowing Detail')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-eye me-2"></i>Borrowing Detail</h1>
            <a href="{{ route('admin.borrowings.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Borrowings
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 200px;">Member</th>
                        <td>
                            <strong>{{ $borrowing->user->name }}</strong><br>
                            <small class="text-muted">{{ $borrowing->user->email }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Book</th>
                        <td>
                            <strong>{{ $borrowing->book->title }}</strong><br>
                            <small class="text-muted">by {{ $borrowing->book->author }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Borrowed Date</th>
                        <td>{{ $borrowing->borrowed_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Returned Date</th>
                        <td>
                            {{ $borrowing->returned_at ? $borrowing->returned_at->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($borrowing->status == 'borrowed')
                                <span class="badge bg-primary">Borrowed</span>
                            @elseif($borrowing->status == 'returned')
                                <span class="badge bg-success">Returned</span>
                            @else
                                <span class="badge bg-danger">Overdue</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Fine</th>
                        <td>
                            @if($borrowing->fine > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($borrowing->fine) }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>

                <div class="d-flex justify-content-end mt-4">
                    @if($borrowing->status == 'borrowed' || $borrowing->status == 'overdue')
                        <form action="{{ route('admin.borrowings.return', $borrowing) }}" method="POST"
                            onsubmit="return confirm('Mark this book as returned?')">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle me-1"></i>Return Book
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection