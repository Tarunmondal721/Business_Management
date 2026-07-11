@extends('layouts.admin.master')

@section('title')
    Permission User
@endsection

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Permission User Management</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.user.index') }}">Permission Users List</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Permission User
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card-style mb-30">

                        <div class="d-flex justify-content-between align-items-center mb-25">
                            <h5 class="mb-0">User Information</h5>

                            <a href="{{ route('admin.user.index') }}" class="main-btn secondary-btn btn-hover btn-sm">
                                <i class="lni lni-arrow-left"></i> Back
                            </a>
                        </div>
                        <form
                            action="{{ isset($user) ? route('admin.user.update', $user->id) : route('admin.user.store') }}"
                            enctype="multipart/form-data" class="ajax-form">

                            @csrf
                            @method(isset($user) ? 'PUT' : 'POST')
                            <div class="row">

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Name <span class="restrick">*</span></label>
                                        <input type="text" name="name" placeholder="Enter Name"
                                            value="{{ old('name', $user->name ?? '') }}">
                                        <span class="text-danger name_error"></span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Email <span class="restrick">*</span></label>
                                        <input type="email" name="email" placeholder="Enter Email"
                                            value="{{ old('email', $user->email ?? '') }}">
                                        <span class="text-danger email_error"></span>
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Phone <span class="restrick">*</span></label>
                                        <input type="text" name="phone" placeholder="Enter Phone Number"
                                            value="{{ old('phone', $user->phone ?? '') }}">
                                        <span class="text-danger phone_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>Role</label>
                                        <div class="select-position">
                                            <select name="role_name" id="role_name">
                                                <option value="">Select Role</option>

                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ old('role_name', $user->role_name ?? '') == $role->name ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <span class="text-danger role_name_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Password</label>

                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password">

                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="#password">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>

                                        <span class="text-danger password_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Confirm Password</label>

                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">

                                            <button class="btn btn-outline-secondary toggle-password" type="button"
                                                data-target="#password_confirmation">
                                                <i class="fa fa-eye-slash"></i>
                                            </button>
                                        </div>

                                        <span class="text-danger password_confirmation_error"></span>
                                    </div>
                                </div>


                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>Status</label>
                                        <div class="select-position">
                                            <select name="status">
                                                <option value="1"
                                                    {{ old('status', $user->status ?? 1) == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $user->status ?? 1) == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <span class="text-danger status_error"></span>
                                    </div>
                                </div>

                                {{-- Address --}}
                                {{-- <div class="col-md-12">
                                    <div class="input-style-1">
                                        <label>Address</label>
                                        <textarea name="address" rows="3" placeholder="Enter Address">{{ old('address', $user->address ?? '') }}</textarea>
                                        <span class="text-danger address_error"></span>
                                    </div>
                                </div> --}}

                                {{-- Image --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <span class="text-danger image_error"></span>
                                    </div>
                                </div>

                                {{-- Image Preview --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Image Preview</label>
                                        <div class="border rounded p-2 text-center" style="height:200px;">
                                            <img id="imagePreview"
                                                src="{{ isset($user) && $user->profile_image ?$user->profile_image : asset('assets/images/img/400x400/img2.jpg') }}"
                                                style="max-width:100%;max-height:180px;margin:auto;display:block;"
                                                alt="Preview">
                                        </div>
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="col-12 mt-4">
                                    <button type="submit" class="main-btn primary-btn btn-hover">
                                        <i class="lni lni-save"></i> Save User
                                    </button>

                                    <button type="reset" id="resetForm" class="main-btn danger-btn btn-hover">
                                        <i class="lni lni-reload"></i> Reset
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).on('change', '#image', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        })

        $(document).on('click', '.toggle-password', function() {

            let input = $($(this).data('target'));

            let icon = $(this).find('i');

            if (input.attr('type') == 'password') {

                input.attr('type', 'text');

                icon.removeClass('fa-eye-slash').addClass('fa-eye');

            } else {

                input.attr('type', 'password');

                icon.removeClass('fa-eye').addClass('fa-eye-slash');

            }

        });
    </script>
@endpush
