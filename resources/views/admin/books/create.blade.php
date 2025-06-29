@extends('layouts.app')

@section('title', 'Add New Book')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="bi bi-plus-circle me-2"></i>Add New Book</h1>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Books
            </a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Author <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('author') is-invalid @enderror"
                                            id="author" name="author" value="{{ old('author') }}" required>
                                        @error('author')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                            id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                            id="stock" name="stock" value="{{ old('stock') }}" min="1" required>
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Book Cover</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Save Book
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6><i class="bi bi-info-circle me-2"></i>Information</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li><i class="bi bi-check-circle text-success me-2"></i>All fields marked with * are required
                            </li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>ISBN must be unique</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Image formats: JPEG, PNG, JPG, GIF</li>
                            <li><i class="bi bi-check-circle text-success me-2"></i>Maximum image size: 2MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // You can add image preview here if needed
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush