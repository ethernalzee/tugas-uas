@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h1>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Books</h6>
                            <h3>{{ $stats['total_books'] }}</h3>
                        </div>
                        <i class="bi bi-book display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Members</h6>
                            <h3>{{ $stats['total_members'] }}</h3>
                        </div>
                        <i class="bi bi-people display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Active Borrowings</h6>
                            <h3>{{ $stats['active_borrowings'] }}</h3>
                        </div>
                        <i class="bi bi-journal-bookmark display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Overdue Books</h6>
                            <h3>{{ $stats['overdue_borrowings'] }}</h3>
                        </div>
                        <i class="bi bi-exclamation-triangle display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history me-2"></i>Recent Borrowings</h5>
                </div>
                <div class="card-body">
                    @if($recent_borrowings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Book</th>
                                        <th>Borrowed Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_borrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ $borrowing->book->title }}</td>
                                            <td>{{ $borrowing->borrowed_at->format('d/m/Y') }}</td>
                                            <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No recent borrowings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection