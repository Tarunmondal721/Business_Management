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

            @include('admin.user.table')
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.deleteBtn')) {
                let id = e.target.closest('.deleteBtn').dataset.id;
                Swal.fire({
                    title: 'Are You Sure Want To Delete This Permission User?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.user.destroy', ':id') }}";
                        url = url.replace(':id', id);
                        let form = document.getElementById('deleteForm');
                        form.action = url;
                        form.submit();
                    }
                })
            }
        })


        $('#UserTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "🔍 Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ Buyer Users",
                paginate: {
                    previous: "←",
                    next: "→"
                }
            },
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
        });
    </script>
@endpush
