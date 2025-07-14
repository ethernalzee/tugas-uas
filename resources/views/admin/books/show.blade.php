@extends('layouts.app')

@section('title', 'Book Detail')

@section('content')
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
        </div>

        <div class="card">
            <div class="row g-0">
                <div class="col-md-4">
                    @if($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="img-fluid rounded-start" style="object-fit: cover; width: 100%; height: 100%;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 100%; min-height: 300px;">
                            <i class="bi bi-book display-1 text-muted"></i>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title">{{ $book->title }}</h3>
                        <p class="text-muted">ISBN: {{ $book->isbn }}</p>

                        <p><strong>Author:</strong> {{ $book->author }}</p>
                        <p><strong>Category:</strong> <span class="badge bg-secondary">{{ $book->category->name }}</span></p>
                        <p><strong>Stock:</strong> {{ $book->stock }}</p>
                        <p><strong>Available:</strong>
                            <span class="badge {{ $book->available_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $book->available_stock }}
                            </span>
                        </p>

                        @if($book->description)
                            <p><strong>Description:</strong></p>
                            <p>{{ $book->description }}</p>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning me-2">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
