@extends('layouts.admin.master')
@section('title', 'Create Role')

@section('content')
    <section class="section">
        <div class="container-fluid">


            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2>Create Role</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.role.index') }}">Roles</a>
                                </li>
                                <li class="breadcrumb-item active">Create Role</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary ">
                    <h5 class="mb-0 text-white">Add New Role</h5>
                </div>

                <div class="card-body">

                    <form class="needs-validation" novalidate action="{{ route('admin.role.store') }}" method="POST">
                        @csrf

                        <!-- ROLE NAME -->
                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control"
                                placeholder="Enter Role Name" value="{{ old('name') }}"
                                required>

                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 d-flex align-items-center gap-3">
                            <label class="form-label">Status</label>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="status" id="statusSwitch"
                                    value="1" checked>
                                <label class="form-check-label" for="statusSwitch">
                                    Active
                                </label>
                            </div>
                        </div>

                        <!-- GLOBAL SELECT ALL -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Module Permissions</h5>

                            <div class="form-check form-switch">
                                <input type="checkbox" id="globalSelectAll" class="form-check-input">
                                <label class="form-check-label fw-bold" for="globalSelectAll">Select All</label>
                            </div>
                        </div>

                        <div class="row">
                            @foreach ($permissions as $module => $perms)
                                <div class="col-md-3 mb-4">

                                    <div class="card border shadow-sm h-100">
                                        <div
                                            class="card-header bg-light fw-bold text-uppercase d-flex justify-content-between">
                                            {{ $module }}

                                            <!-- MODULE-WISE SELECT ALL -->
                                            <input type="checkbox" class="form-check-input module-select-all"
                                                data-module="{{ $module }}">
                                        </div>

                                        <div class="card-body">
                                            @foreach ($perms as $perm)
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" name="permissions[]"
                                                        class="form-check-input perm-checkbox module-checkbox module-{{ $module }}"
                                                        value="{{ $perm->name }}" id="perm_{{ $perm->id }}">

                                                    <label class="form-check-label" for="perm_{{ $perm->id }}">
                                                        {{ ucfirst(explode('.', $perm->name)[1]) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">
                            <i class="bi bi-check-circle"></i> Create Role
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // 🔹 GLOBAL SELECT ALL
            $('#globalSelectAll').on('change', function() {
                const checked = $(this).is(':checked');
                $('.perm-checkbox').prop('checked', checked);
                $('.module-select-all').prop('checked', checked);
            });

            // 🔹 MODULE-WISE SELECT ALL
            $('.module-select-all').on('change', function() {
                const module = $(this).data('module');
                const checked = $(this).is(':checked');
                $('.module-' + module).prop('checked', checked);
                $('#globalSelectAll').prop('checked', $('.perm-checkbox:not(:checked)').length === 0);

            });

            // 🔹 Auto-update module-select-all checkbox
            $('.module-checkbox').on('change', function() {
                let module = $(this).attr('class').split('module-')[1]; // extract module name
                let allChecked = $('.module-' + module + ':not(:checked)').length === 0;
                $('.module-select-all[data-module="' + module + '"]').prop('checked', allChecked);
            });

            // 🔹 Auto-update GLOBAL checkbox
            $('.perm-checkbox').on('change', function() {
                let allChecked = $('.perm-checkbox:not(:checked)').length === 0;
                $('#globalSelectAll').prop('checked', allChecked);
            });

        });



    </script>
@endpush
