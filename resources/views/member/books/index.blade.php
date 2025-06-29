@extends('layouts.app')

@section('title', 'Browse Books')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="bi bi-book me-2"></i>Browse Books</h1>
                <span class="text-muted">{{ $books->total() }} books available</span>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('member.books.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Search Books</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Title, Author, or ISBN" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-search me-1"></i>Search
                            </button>
                            <a href="{{ route('member.books.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        @if($books->count() > 0)
            @foreach($books as $book)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text text-muted">{{ $book->author }}</p>
                            <p class="card-text small">
                                <span class="badge bg-secondary">{{ $book->category->name }}</span>
                            </p>
                            <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="bi bi-stack me-1"></i>Available: {{ $book->available_stock }}/{{ $book->stock }}
                                    </small>
                                    @if($book->available_stock > 0)
                                        <span class="badge bg-success">Available</span>
                                    @else
                                        <span class="badge bg-danger">Not Available</span>
                                    @endif
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('member.books.show', $book) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3">No Books Found</h4>
                        <p class="text-muted">Try adjusting your search criteria or browse all categories.</p>
                        <a href="{{ route('member.books.index') }}" class="btn btn-primary">Browse All Books</a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($books->hasPages())
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection