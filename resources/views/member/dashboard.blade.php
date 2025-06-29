@extends('layouts.app')

@section('title', 'Member Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="bi bi-house me-2"></i>Dashboard</h1>
                    <span class="text-muted">Welcome back, {{ auth()->user()->name }}!</span>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Active Borrowings</h5>
                                <h2 class="mb-0">{{ $stats['active_borrowings'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-book-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Borrowings</h5>
                                <h2 class="mb-0">{{ $stats['total_borrowings'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-journal-bookmark-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-{{ $stats['overdue_borrowings'] > 0 ? 'danger' : 'info' }} text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Overdue Books</h5>
                                <h2 class="mb-0">{{ $stats['overdue_borrowings'] }}</h2>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Borrowings -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Borrowings</h5>
                        <a href="{{ route('member.borrowings.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recent_borrowings->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recent_borrowings as $borrowing)
                                    <div class="list-group-item px-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $borrowing->book->title }}</h6>
                                                <p class="mb-1 text-muted small">{{ $borrowing->book->author }}</p>
                                                <small class="text-muted">
                                                    Borrowed: {{ $borrowing->borrowed_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                            <span
                                                class="badge bg-{{ $borrowing->status == 'borrowed' ? 'primary' : ($borrowing->status == 'returned' ? 'success' : 'danger') }}">
                                                {{ ucfirst($borrowing->status) }}
                                            </span>
                                        </div>
                                        @if($borrowing->status == 'borrowed')
                                            <small class="text-warning">
                                                <i class="bi bi-calendar-event me-1"></i>
                                                Due: {{ $borrowing->due_date->format('d/m/Y') }}
                                            </small>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-journal-x fs-1 mb-2"></i>
                                <p>No borrowing history yet</p>
                                <a href="{{ route('member.books.index') }}" class="btn btn-primary">Browse Books</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Available Books -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-book me-2"></i>New Available Books</h5>
                        <a href="{{ route('member.books.index') }}" class="btn btn-sm btn-outline-primary">Browse All</a>
                    </div>
                    <div class="card-body">
                        @if($available_books->count() > 0)
                            <div class="row">
                                @foreach($available_books->take(4) as $book)
                                    <div class="col-6 mb-3">
                                        <div class="card h-100">
                                            @if($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top"
                                                    style="height: 120px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 120px;">
                                                    <i class="bi bi-book text-muted fs-1"></i>
                                                </div>
                                            @endif
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1" style="font-size: 0.9rem;">
                                                    {{ Str::limit($book->title, 30) }}</h6>
                                                <p class="card-text text-muted small mb-2">{{ Str::limit($book->author, 20) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">{{ $book->category->name }}</small>
                                                    <a href="{{ route('member.books.show', $book) }}"
                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-book fs-1 mb-2"></i>
                                <p>No books available at the moment</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($stats['overdue_borrowings'] > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="alert alert-warning">
                        <h5><i class="bi bi-exclamation-triangle me-2"></i>Attention!</h5>
                        <p class="mb-0">You have {{ $stats['overdue_borrowings'] }} overdue book(s). Please return them as soon
                            as possible to avoid additional fines.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection