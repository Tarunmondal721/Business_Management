@extends('layouts.admin.master')

@section('title')
    Create Role
@endsection


@section('content')
    <section class="section">
        <div class="container-fluid">

            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Role Management</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Role
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->
            <!-- Role Details Modal -->
            <div class="modal fade" id="roleModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Role Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <h5 id="roleName" class="mb-3"></h5>
                            <div id="rolePermissions" class="row g-2"></div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========== Roles Table ========== -->
            <div class="row mt-30">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0 rounded">

                        <div class="card-header bg-primary  d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-white">All Roles</h5>
                            <a href="{{ route('admin.role.create') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-plus-circle"></i> Add Role
                            </a>
                        </div>

                        <div class="card-body">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class ="table table-hover table-striped table-bordered text-center align-middle" id="roleTable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col"  class="text-center">Role Name</th>
                                                <th scope="col" class="text-center">Permissions</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $index => $role)
                                                <tr>
                                                    <th scope="row">{{ $index + 1 }}</th>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        @if ($role->permissions->isEmpty())
                                                            <span class="text-muted">No permissions assigned</span>
                                                        @else
                                                            @foreach ($role->permissions as $permission)
                                                                <span
                                                                    class="badge bg-secondary">{{ $permission->name }}</span>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-info btn-sm viewRoleBtn"
                                                            data-id="{{ $role->id }}" data-name="{{ $role->name }}" title="View Permissions">
                                                            <i class="fa-solid fa-eye" ></i>
                                                        </button>
                                                        <a href="{{ route('admin.role.edit', $role->id) }}"
                                                            class="btn btn-outline-warning btn-sm" title="Edit Role">
                                                          <i class="fa-solid fa-pencil"></i>
                                                        </a>
                                                        <button data-id="{{ $role->id }}"
                                                            class="btn btn-sm btn-outline-danger deleteBtn" title="Delete Role">
                                                            <i class="lni lni-trash-can"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <form id="deleteForm" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')


    <script>
        document.addEventListener("click", function(e) {
            if (e.target.closest(".deleteBtn")) {

                let id = e.target.closest(".deleteBtn").dataset.id;
                console.log(id);
                swal.fire({
                    title: 'Are you sure you want to delete this role?',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    showCancelButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.role.destroy', ':id') }}";
                        url = url.replace(':id', id);
                        console.log(url);

                        let form = document.getElementById('deleteForm');
                        form.action = url;
                        form.submit();
                    }
                })
            }
        });

        $(document).on('click', '.viewRoleBtn', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');

            $("#roleName").text("Role: " + name);
            $("#rolePermissions").html("<p>Loading...</p>");

            $.ajax({
                url: "/admin/role/" + id,
                type: "GET",
                success: function(res) {

                    let html = "";

                    if (res.permissions.length === 0) {
                        html = "<p class='text-muted'>No permissions assigned.</p>";
                    } else {
                        res.permissions.forEach(function(p) {
                            html += `
                        <div class="col-md-3">
                            <span class="badge bg-secondary w-100 py-2">
                                ${p}
                            </span>
                        </div>`;
                        });
                    }

                    $("#rolePermissions").html(html);

                    $("#roleModal").modal("show");
                }
            });

        });
    </script>

    <script>
$('#roleTable').DataTable({
    responsive:true,
    pageLength:10,
    language:{
        search:"🔍 Search:",
        lengthMenu:"Show _MENU_ Roles",
        info:"Showing _START_ to _END_ of _TOTAL_ Roles",
        paginate:{
            previous:"←",
            next:"→"
        }
    },
    columnDefs:[
        {
            targets:[3],
            orderable:false
        }
    ]
});
</script>
@endpush
