@extends('layouts.app')

@section('title', 'Manage Books')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-book me-2"></i>Manage Books</h1>
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Book
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($books->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Available</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td>
                                            @if($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                                    class="img-thumbnail" style="width: 50px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 60px;">
                                                    <i class="bi bi-book text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $book->title }}</strong><br>
                                            <small class="text-muted">ISBN: {{ $book->isbn }}</small>
                                        </td>
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $book->category->name }}</span>
                                        </td>
                                        <td>{{ $book->stock }}</td>
                                        <td>
                                            <span class="badge {{ $book->available_stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                {{ $book->available_stock }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.books.show', $book) }}" class="btn btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger"
                                                        onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $books->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-book display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No books found</h5>
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Add First Book
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection