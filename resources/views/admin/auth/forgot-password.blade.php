@extends('admin.auth.layouts.main')

@section('title')
    Forgot Password - Admin panel
@endsection

@section('content')
    <section class="d-flex align-items-center" style="min-height:100vh; background:#f5f7fb;">

        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                        <div class="row g-0">

                            <!-- Left Image Panel -->
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="position-relative h-100" style="background:#eef4ff;">

                                    <div class="text-center" style="padding: 10%;">
                                        <h2 class="text-primary fw-bold">Password Assistance</h2>
                                        <p class="text-secondary mt-2">
                                            Enter your email to recover your password.
                                            If you need help, feel free to <a href="#0"
                                                class="text-decoration-none">contact support</a>.
                                        </p>
                                    </div>

                                    <div class="text-center">
                                        <img src="{{ asset('assets/images/auth/reset-password.svg') }}"
                                            class="img-fluid p-4" alt="Reset Password Illustration"
                                            style="max-height:330px;">
                                    </div>

                                    <img src="{{ asset('assets/images/auth/shape.svg') }}"
                                        class="position-absolute bottom-0 start-0 w-100" alt="">
                                </div>
                            </div>

                            <!-- Right Form Panel -->
                            <div class="col-lg-6 d-flex align-items-center bg-white">
                                <div class="p-5 w-100">

                                    <div class="text-center mb-4">
                                        <div class="d-inline-flex rounded-circle justify-content-center align-items-center"
                                            style="width:70px; height:70px; background:#f0f4ff;">
                                            <i class="bi bi-envelope-paper-fill text-primary" style="font-size:30px;"></i>
                                        </div>
                                    </div>

                                    <h3 class="fw-bold text-center mb-3">Forgot Password?</h3>
                                    <p class="text-center text-muted mb-4">
                                        Enter your registered email and we’ll send you reset instructions.
                                    </p>

                                    <!-- Errors -->
                                    {{-- @if ($errors->any())
                                        <div
                                            class="alert alert-danger alert-dismissible fade show text-center rounded-pill py-2">
                                            <strong>Error:</strong> {{ $errors->first() }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif --}}

                                    <!-- Success Message -->
                                    {{-- @if (session('status') || session('success'))
                                        <div
                                            class="alert alert-success alert-dismissible fade show rounded-pill text-center mb-4 py-2">
                                            <i class="bi bi-check-circle me-2"></i>
                                            {{ session('status') ?? session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif --}}

                                    <form action="{{ route('admin.forgot.password.email') }}" method="POST">
                                        @csrf

                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" name="email" class="form-control form-control-lg"
                                                    placeholder="Enter your email" required>
                                            </div>
                                        </div>

                                        <!-- Button -->
                                        <button class="btn btn-primary btn-lg w-100 rounded-pill mt-3">
                                            <i class="bi bi-send-check me-1"></i>
                                            Send Reset Link
                                        </button>
                                    </form>

                                    <div class="text-center mt-4">
                                        <a href="{{ route('admin.login') }}"
                                            class="text-primary text-decoration-none small">
                                            <i class="bi bi-arrow-left me-1"></i>
                                            Back to Login
                                        </a>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
