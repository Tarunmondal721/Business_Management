@extends('admin.auth.layouts.main')

@section('title')
    Login - Admin Panel
@endsection

@section('content')
    <section class="signin-section d-flex align-items-center" style="min-height:100vh;">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                        <div class="row g-0">

                            <!-- LEFT IMAGE -->
                            <div
                                class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-light text-dark">
                                <div class="text-center p-5">
                                    <h2 class="fw-bold mb-3">Welcome Back</h2>
                                    <p class="opacity-75 mb-4">Login to manage your admin dashboard</p>
                                    <img src="{{ asset('assets/images/auth/signin-image.svg') }}" class="img-fluid mt-3"
                                        style="max-height:300px;">
                                </div>
                            </div>

                            <!-- RIGHT FORM -->
                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="p-5 w-100">

                                    <h3 class="fw-bold mb-4 text-center">Admin Login</h3>

                                    {{-- Error --}}
                                    @if (session('error'))
                                        <div class="alert alert-danger text-center">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.login') }}" method="POST" id="loginForm">
                                        @csrf

                                        <!-- EMAIL -->
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="lni lni-envelope"></i>
                                                </span>
                                                <input type="email" name="email"
                                                    class="form-control bg-outline-none form-control-lg" required
                                                    placeholder="Enter email" value="{{ old('email') }}">
                                            </div>
                                        </div>

                                        <!-- PASSWORD -->
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="lni lni-lock"></i>
                                                </span>
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-lg" required
                                                    placeholder="Enter password">
                                                <span class="input-group-text cursor-pointer"
                                                    onclick="togglePassword('password', 'toggleIcon')">
                                                    <i id="toggleIcon" class="fa fa-eye-slash"></i>
                                                </span>

                                            </div>
                                        </div>

                                        <!-- REMEMBER -->
                                        <div class="text-end mb-4">
                                            {{-- <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label">Remember me</label>
                                            </div> --}}

                                            <a href="{{ route('admin.forgot.password') }}" class="text-primary fw-medium">
                                                Forgot Password?
                                            </a>
                                        </div>

                                        <!-- LOGIN BUTTON -->
                                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                            <span class="login-text">Sign In</span>
                                        </button>
                                    </form>

                                    <!-- SOCIAL LOGIN -->
                                    {{-- <div class="text-center mt-4">
                                        <p class="text-muted mb-3">Or sign in with</p>

                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="{{ route('admin.social.redirect', 'facebook') }}"
                                                class="btn btn-outline-primary rounded-pill px-4">
                                                <i class="lni lni-facebook-fill me-2"></i> Facebook
                                            </a>

                                            <a href="{{ route('admin.social.redirect', 'google') }}"
                                                class="btn btn-outline-danger rounded-pill px-4">
                                                <i class="lni lni-google me-2"></i> Google
                                            </a>
                                        </div>
                                    </div> --}}

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";

                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

            } else {
                input.type = "password";

                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }
    </script>
@endsection
