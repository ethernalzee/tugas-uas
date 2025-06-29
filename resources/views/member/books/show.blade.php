@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="{{ route('member.books.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to Books
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                @if($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" style="height: 400px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-book text-muted" style="font-size: 6rem;"></i>
                    </div>
                @endif
                <div class="card-body text-center">
                    @if($book->available_stock > 0)
                        <span class="badge bg-success fs-6 mb-2">
                            <i class="bi bi-check-circle me-1"></i>Available
                        </span>
                        <p class="text-muted mb-3">{{ $book->available_stock }} copies available</p>
                        
                        @php
                            $user = auth()->user();
                            $activeBorrowings = $user->activeBorrowings()->count();
                            $overdueBorrowings = $user->borrowings()->where('status', 'overdue')->count();
                            $alreadyBorrowed = $user->borrowings()->where('book_id', $book->id)->where('status', 'borrowed')->exists();
                        @endphp

                        @if($overdueBorrowings > 0)
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                You have overdue books. Please return them first.
                            </div>
                        @elseif($activeBorrowings >= 3)
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-1"></i>
                                You've reached the borrowing limit (3 books).
                            </div>
                        @elseif($alreadyBorrowed)
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-1"></i>
                                You've already borrowed this book.
                            </div>
                        @else
                            <form action="{{ route('member.books.borrow', $book) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg w-100" 
                                        onclick="return confirm('Are you sure you want to borrow this book?')">
                                    <i class="bi bi-journal-plus me-2"></i>Borrow Book
                                </button>
                            </form>
                            <small class="text-muted mt-2 d-block">Return within 14 days</small>
                        @endif
                    @else
                        <span class="badge bg-danger fs-6 mb-2">
                            <i class="bi bi-x-circle me-1"></i>Not Available
                        </span>
                        <p class="text-muted">All copies are currently borrowed</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title mb-3">{{ $book->title }}</h1>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold">Author:</td>
                                    <td>{{ $book->author }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">ISBN:</td>
                                    <td>{{ $book->isbn }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Category:</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $book->category->name }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Stock:</td>
                                    <td>{{ $book->available_stock }}/{{ $book->stock }} available</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($book->description)
                        <div class="mb-4">
                            <h5>Description</h5>
                            <p class="text-muted">{{ $book->description }}</p>
                        </div>
                    @endif

                    <!-- Current Borrowers (if any) -->
                    @if($book->activeBorrowings()->count() > 0)
                        <div class="mb-4">
                            <h5>Currently Borrowed By</h5>
                            <div class="list-group">
                                @foreach($book->activeBorrowings as $borrowing)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>{{ $borrowing->user->name }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    Borrowed: {{ $borrowing->borrowed_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-warning">
                                                    Due: {{ $borrowing->due_date->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection