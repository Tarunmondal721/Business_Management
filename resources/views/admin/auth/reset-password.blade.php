@extends('admin.auth.layouts.main')

@section('title', 'Reset Password - Admin Panel')




@section('content')

<section class="d-flex align-items-center" style="min-height:100vh; background:#f5f7fb;">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5" style="padding: 4%;">

                <div class="card shadow-lg border-0 rounded-4 p-4" style="background:#ffffff;">

                    <!-- Icon -->
                    <div class="text-center mb-3">
                        <div class="rounded-circle d-inline-flex justify-content-center align-items-center"
                             style="width:70px; height:70px; background:#eef4ff;">
                            <i class="bi bi-shield-lock-fill text-primary" style="font-size:32px;"></i>
                        </div>
                    </div>

                    <h3 class="text-center fw-bold mb-2">Reset Your Password</h3>
                    <p class="text-center text-muted mb-4">
                        Choose a strong new password to secure your admin account.
                    </p>

                    {{-- @if ($errors->any())
                        <div class="alert alert-danger text-center rounded-pill py-2">
                            <i class="bi bi-exclamation-circle"></i> Please fix the errors below
                        </div>
                    @endif --}}

                    <form action="{{ route('admin.reset.password') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="email" readonly
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Email Address"
                                       value="{{ old('email', $email->email ?? '') }}" required>
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="New Password" required>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" name="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirm Password" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn w-100 py-2 rounded-pill text-white"
                                style="background: linear-gradient(135deg, #4e73df, #1cc88a); font-size:16px;">
                            <i class="bi bi-check2-circle me-1"></i> Reset Password
                        </button>

                        <div class="text-center mt-4">
                            <a href="{{ route('admin.login') }}" class="text-primary small text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Back to Login
                            </a>
                        </div>

                    </form>

                </div>

                {{-- <div class="text-center text-muted small mt-3">
                    © {{ date('Y') }} Admin Panel • All rights reserved
                </div> --}}

            </div>
        </div>

    </div>
</section>

@endsection

