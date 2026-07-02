@extends('layouts.admin.master')

@section('title')
    Seller User
@endsection

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Seller User Management</h2>
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
                                        <a href="{{ route('admin.seller-user.index') }}">Seller Users List</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Seller User
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
                            <h5 class="mb-0">Seller Information</h5>

                            <a href="{{ route('admin.seller-user.index') }}"
                                class="main-btn secondary-btn btn-hover btn-sm">
                                <i class="lni lni-arrow-left"></i> Back
                            </a>
                        </div>

                        <form
                            action="{{ isset($sellerUser) ? route('admin.seller-user.update', $sellerUser->id) : route('admin.seller-user.store') }}"
                            method="POST" enctype="multipart/form-data" class="ajax-form">

                            @csrf
                            @if (isset($sellerUser))
                                @method('PUT')
                            @endif

                            <div class="row">

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Name <span class="restrick">*</span></label>
                                        <input type="text" name="name" placeholder="Enter Name"
                                            value="{{ old('name', $sellerUser->name ?? '') }}">
                                        <span class="text-danger name_error"></span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Enter Email"
                                            value="{{ old('email', $sellerUser->email ?? '') }}">
                                        <span class="text-danger email_error"></span>
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Phone <span class="restrick">*</span></label>
                                        <input type="text" name="phone" placeholder="Enter Phone Number"
                                            value="{{ old('phone', $sellerUser->phone ?? '') }}">
                                        <span class="text-danger phone_error"></span>
                                    </div>
                                </div>

                                {{-- Country --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Country</label>
                                        <input type="text" name="country" placeholder="Enter Country"
                                            value="{{ old('country', $sellerUser->country ?? '') }}">
                                        <span class="text-danger country_error"></span>
                                    </div>
                                </div>

                                {{-- Company Name --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Company Name</label>
                                        <input type="text" name="company_name" placeholder="Enter Company Name"
                                            value="{{ old('company_name', $sellerUser->company_name ?? '') }}">
                                        <span class="text-danger company_name_error"></span>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>Status</label>
                                        <div class="select-position">
                                            <select name="status">
                                                <option value="1"
                                                    {{ old('status', $sellerUser->status ?? 1) == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $sellerUser->status ?? 1) == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <span class="text-danger status_error"></span>
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-12">
                                    <div class="input-style-1">
                                        <label>Address</label>
                                        <textarea name="address" rows="3" placeholder="Enter Address">{{ old('address', $sellerUser->address ?? '') }}</textarea>
                                        <span class="text-danger address_error"></span>
                                    </div>
                                </div>

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
                                                src="{{ isset($sellerUser) && $sellerUser->image ? asset('storage/seller_users/' . $sellerUser->image) : asset('assets/images/img/400x400/img2.jpg') }}"
                                                style="max-width:100%;max-height:180px;margin:auto;display:block;"
                                                alt="Preview">
                                        </div>
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="col-12 mt-4">
                                    <button type="submit" class="main-btn primary-btn btn-hover">
                                        <i class="lni lni-save"></i> Save Seller
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
    </script>
@endpush
