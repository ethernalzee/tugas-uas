@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-tags me-2"></i>Manage Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Category
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Books Count</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>{{ $category->description ?? 'No description' }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $category->books_count }} books</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.categories.show', $category) }}"
                                                    class="btn btn-outline-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.categories.edit', $category) }}"
                                                    class="btn btn-outline-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
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
                        {{ $categories->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-tags display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No categories found</h5>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Add First Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection