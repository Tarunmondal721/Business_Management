@extends('layouts.admin.master')

@section('title')
    Fish Management
@endsection

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Fish Management</h2>
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
                                        <a href="{{ route('admin.fish.index') }}">Fish List</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Fish
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
                            <h5 class="mb-0">FIsh Information</h5>

                            <a href="{{ route('admin.fish.index') }}"
                                class="main-btn secondary-btn btn-hover btn-sm">
                                <i class="lni lni-arrow-left"></i> Back
                            </a>
                        </div>
                        <form
                            action="{{ isset($fish) ? route('admin.fish.update', $fish->id) : route('admin.fish.store') }}"
                            enctype="multipart/form-data" class="ajax-form">

                            @csrf
                            @method(isset($fish) ? 'PUT' : 'POST')
                            <div class="row">

                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="input-style-1">
                                        <label>Name <span class="restrick">*</span></label>
                                        <input type="text" name="name" placeholder="Enter Name"
                                            value="{{ old('name', $fish->name ?? '') }}">
                                        <span class="text-danger name_error"></span>
                                    </div>
                                </div>







                                {{-- Status --}}
                                <div class="col-md-6">
                                    <div class="select-style-1">
                                        <label>Status</label>
                                        <div class="select-position">
                                            <select name="status">
                                                <option value="1"
                                                    {{ old('status', $fish->status ?? 1) == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $fish->status ?? 1) == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                        <span class="text-danger status_error"></span>
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
                                                src="{{ isset($fish) && $fish->image ? asset('storage/fish/' . $fish->image) : asset('assets/images/img/400x400/img2.jpg') }}"
                                                style="max-width:100%;max-height:180px;margin:auto;display:block;"
                                                alt="Preview">
                                        </div>
                                    </div>
                                </div>

                                {{-- Buttons --}}
                                <div class="col-12 mt-4">
                                    <button type="submit" class="main-btn primary-btn btn-hover">
                                        <i class="lni lni-save"></i> Save 
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
