@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <i class="bi bi-book display-1 text-primary"></i>
                <h1 class="display-4 fw-bold text-primary">Library Management System</h1>
                <p class="lead text-muted">Sistem Manajemen Perpustakaan Digital</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-person-gear display-4 text-warning"></i>
                            <h5 class="card-title mt-3">Admin Panel</h5>
                            <p class="card-text">Kelola buku, kategori, dan peminjaman dengan mudah</p>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-warning">
                                        <i class="bi bi-speedometer2 me-2"></i>Go to Dashboard
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-people display-4 text-success"></i>
                            <h5 class="card-title mt-3">Member Area</h5>
                            <p class="card-text">Browse dan pinjam buku favorit Anda</p>
                            @auth
                                @if(auth()->user()->isMember())
                                    <a href="{{ route('member.dashboard') }}" class="btn btn-success">
                                        <i class="bi bi-house me-2"></i>Go to Dashboard
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            @guest
                <div class="text-center mt-5">
                    <p class="text-muted">Belum punya akun?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </a>
                </div>
            @endguest
        </div>
    </div>
</div>
@endsection