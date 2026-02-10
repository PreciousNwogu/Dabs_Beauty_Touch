@extends('layouts.app')

@section('title', 'Sign In - Dab\'s Beauty Touch')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius:16px;">
                <div class="card-body p-4">
                    <h3 class="mb-2" style="font-weight:800;color:#0b3a66;">Sign In</h3>
                    <p class="text-muted mb-4">Access your bookings and rebook faster.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" required autocomplete="current-password">
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('register') }}" style="text-decoration:none;font-weight:600;">Create account</a>
                        </div>
                        <button class="btn btn-primary w-100" type="submit" style="border-radius:12px;font-weight:800;">
                            Sign In
                        </button>
                        <div class="text-center mt-3">
                            <a href="{{ route('home') }}" class="text-muted" style="text-decoration:none;">Continue as guest</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

