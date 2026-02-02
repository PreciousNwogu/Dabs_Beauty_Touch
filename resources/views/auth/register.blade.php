@extends('layouts.app')

@section('title', 'Create Account - Dab\'s Beauty Touch')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius:16px;">
                <div class="card-body p-4">
                    <h3 class="mb-2" style="font-weight:800;color:#0b3a66;">Create Account</h3>
                    <p class="text-muted mb-4">Optional — you can still book as a guest.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full name</label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autocomplete="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input class="form-control" type="password" name="password" required autocomplete="new-password">
                            <div class="form-text">Use at least 8 characters.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm password</label>
                            <input class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <button class="btn btn-primary w-100" type="submit" style="border-radius:12px;font-weight:800;">
                            Create account
                        </button>
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" style="text-decoration:none;font-weight:600;">Already have an account? Sign in</a>
                        </div>
                        <div class="text-center mt-2">
                            <a href="{{ route('home') }}" class="text-muted" style="text-decoration:none;">Continue as guest</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

