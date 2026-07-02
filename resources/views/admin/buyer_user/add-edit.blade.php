@extends('layouts.admin.master')

@section('title')
    Buyer User
@endsection

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Buyer User Management</h2>
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
                                        <a href="{{ route('admin.buyer-user.index') }}">Buyer Users List</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Buyer User
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
                            <h5 class="mb-0">Buyer Information</h5>

                            <a href="{{ route('admin.buyer-user.index') }}" class="main-btn secondary-btn btn-hover btn-sm">
                                <i class="lni lni-arrow-left"></i> Back
                            </a>
                        </div>

                        <form
                            action="{{ isset($buyerUser) ? route('admin.buyer-user.update', $buyerUser->id) : route('admin.buyer-user.store') }}"
                            enctype="multipart/form-data" class="ajax-form">
                            @method(isset($buyerUser) ? 'PUT' : 'POST')

                            @csrf

                            <div class="row">

                                {{-- Buyer Code --}}
                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label>Buyer Code <span class="restrick">*</span></label>
                                        <input type="text" name="buyer_code" placeholder="Auto / Manual"
                                            value="{{ $buyerUser->buyer_code ?? 'BUYER' . rand(1000, 9999) }}" readonly>
                                        <span class="text-danger buyer_code_error"></span>
                                    </div>
                                </div>

                                {{-- Buyer Name --}}
                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label>Buyer Name <span class="restrick">*</span></label>
                                        <input type="text" name="name" placeholder="Enter Buyer Name"
                                            value="{{ $buyerUser->name ?? '' }}">
                                        <span class="text-danger name_error"></span>
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-4">
                                    <div class="input-style-1">
                                        <label>Phone <span class="restrick">*</span></label>
                                        <input type="text" name="phone" placeholder="Enter Phone Number"
                                            value="{{ $buyerUser->phone ?? '' }}">
                                        <span class="text-danger phone_error"></span>
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Email</label>
                                        <input type="email" name="email" placeholder="Enter Email"
                                            value="{{ $buyerUser->email ?? '' }}">
                                        <span class="text-danger email_error"></span>
                                    </div>
                                </div>

                                {{-- Buyer Type --}}
                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>  Buyer Type <span class="restrick">*</span></label>
                                        <div class="select-position">
                                            <select name="type">
                                                <option value="">Select Buyer Type</option>
                                                <option value="agent"
                                                    {{ old('type', $buyerUser->type ?? '') == 'agent' ? 'selected' : '' }}>
                                                    Agent</option>
                                                {{-- <option value="retail" {{ old('type', $buyerUser->type ?? '') == 'retail' ? 'selected' : '' }}>Retail</option> --}}
                                                <option value="wholeseller"
                                                    {{ old('type', $buyerUser->type ?? '') == 'wholeseller' ? 'selected' : '' }}>
                                                    Wholeseller</option>
                                            </select>
                                        </div>
                                        <span class="text-danger type_error"></span>
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-12">
                                    <div class="input-style-1">
                                        <label>Buyer Address</label>
                                        <textarea name="address" rows="3" placeholder="Buyer Address">{{ $buyerUser->address ?? '' }}</textarea>
                                        <span class="text-danger address_error"></span>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="col-12 mb-3">
                                    <h6>Market Information</h6>
                                </div>

                                {{-- Market Name --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Market Name</label>
                                        <input type="text" name="market_name" placeholder="Market Name"
                                            value="{{ $buyerUser->market_name ?? '' }}">
                                        <span class="text-danger market_name_error"></span>
                                    </div>
                                </div>

                                {{-- Market Address --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Market Address</label>
                                        <input type="text" name="market_address" placeholder="Market Address"
                                            value="{{ $buyerUser->market_address ?? '' }}">
                                        <span class="text-danger market_address_error"></span>
                                    </div>
                                </div>

                                {{-- Image --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Buyer Image</label>
                                        <input type="file" name="image" id="image" class="form-control">
                                        <span class="text-danger image_error"></span>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>Status</label>
                                        <div class="select-position">
                                            <select name="status">
                                                <option value="1"
                                                    {{ old('status', $buyerUser->status ?? '') == 1 ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0"
                                                    {{ old('status', $buyerUser->status ?? '') == 0 ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                        <span class="text-danger status_error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="input-style-1">
                                        <label>Image Preview</label>
                                        <div class="border rounded p-2 text-center" style="height: 200px;">
                                            <img id="imagePreview" src="{{ isset($buyerUser) ? asset('storage/buyer_users/' . $buyerUser->image) : asset('assets/images/img/400x400/img2.jpg') }}" alt="Preview"
                                                style="max-width:100%; max-height:180px; display:block; margin:auto;">
                                        </div>
                                    </div>

                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="main-btn primary-btn btn-hover">
                                        <i class="lni lni-save"></i>
                                        Save Buyer
                                    </button>

                                    <button type="reset" id="resetForm" class="main-btn danger-btn btn-hover">
                                        <i class="lni lni-reload"></i>
                                        Reset
                                    </button>
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
    $(document).on('change','#image',function(){
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#imagePreview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    })
</script>
@endpush
