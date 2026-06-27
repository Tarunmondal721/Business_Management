@extends('layouts.admin.master')

@section('title', 'Edit Role')
@section('content')

    <section class="section">
        <div class="container-fluid">

            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2>Edit Role</h2>
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
                                <li class="breadcrumb-item active">Edit Role</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-primary ">
                    <h5 class="mb-0 text-white">Update Role</h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')


                        <!-- Role Name -->
                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" value="{{ ucfirst($role->name) }}" class="form-control"
                                required>
                        </div>

                        <!-- Status Switch -->
                        <div class="mb-3 d-flex align-items-center gap-3">
                            <label class="form-label mb-0">Status</label>

                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" name="status" id="statusSwitch"
                                    value="1" {{ $role->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusSwitch">
                                    {{ $role->status ? 'Active' : 'Inactive' }}
                                </label>
                            </div>
                        </div>


                        <!-- GLOBAL SELECT ALL -->
                        <!-- GLOBAL SELECT ALL -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Module Permissions</h5>

                            <div class="form-check form-switch">
                                <input type="checkbox" id="globalSelectAll" class="form-check-input">
                                <label class="form-check-label fw-bold"
                                    for="globalSelectAll">Select All</label>
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
                                                        class="form-check-input perm-checkbox module-checkbox"
                                                        data-module="{{ $module }}" value="{{ $perm->name }}"
                                                        id="perm_{{ $perm->id }}"
                                                        {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>

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


                        <button type="submit" class="btn btn-success mt-3">
                            <i class="bi bi-save"></i> Update Role
                        </button>

                    </form>
                </div>

            </div>

        </div>

        </div>
    </section>

@endsection

@push('scripts')

    <script>
        $(document).ready(function() {

            // GLOBAL SELECT ALL
            $('#globalSelectAll').on('change', function() {
                const checked = $(this).is(':checked');
                $('.perm-checkbox').prop('checked', checked);
                $('.module-select-all').prop('checked', checked);
            });

            //  MODULE SELECT ALL
            $('.module-select-all').on('change', function() {
                let module = $(this).data('module');
                let checked = $(this).is(':checked');
                $('.module-checkbox[data-module="' + module + '"]').prop('checked', checked);

                // Update global
                $('#globalSelectAll').prop('checked', $('.perm-checkbox:not(:checked)').length === 0);
            });

            // INDIVIDUAL PERMISSION CHANGE
            $('.module-checkbox').on('change', function() {
                let module = $(this).data('module');

                // Check if all perms inside module are checked
                let allModuleChecked = $('.module-checkbox[data-module="' + module + '"]:not(:checked)')
                    .length === 0;
                $('.module-select-all[data-module="' + module + '"]').prop('checked', allModuleChecked);

                // Now update global select-all
                let allGlobalChecked = $('.perm-checkbox:not(:checked)').length === 0;
                $('#globalSelectAll').prop('checked', allGlobalChecked);
            });

            function initializeSelections() {

                $('.module-select-all').each(function() {
                    let module = $(this).data('module');

                    let allChecked = $('.module-checkbox[data-module="' + module + '"]:not(:checked)')
                        .length === 0;

                    $(this).prop('checked', allChecked);
                });

                let allGlobalChecked = $('.perm-checkbox:not(:checked)').length === 0;
                $('#globalSelectAll').prop('checked', allGlobalChecked);
            }

            initializeSelections();


        });
    </script>
@endpush
