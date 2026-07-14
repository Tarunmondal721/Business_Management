@extends('layouts.admin.master')

@section('title', 'Selling Management')

@section('content')

    <section class="section">
        <div class="container-fluid">

            {{-- Title --}}
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>Selling Management</h2>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        Selling List
                                    </li>

                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>


            {{-- Table --}}
            <div class="row mt-30">

                <div class="col-lg-12">

                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-primary d-flex justify-content-between align-items-center">

                            <h5 class="text-white mb-0">
                                <i class="fa-solid fa-truck-fast me-2"></i>
                                Selling List
                            </h5>

                            @can('selling.create')
                                <a href="{{ route('admin.selling.create') }}" class="btn btn-light btn-sm">

                                    <i class="fa fa-plus"></i>
                                    Add Selling

                                </a>
                            @endcan

                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table class="table table-bordered table-hover align-middle" id="sellingTable">

                                    <thead class="table-light ">

                                        <tr >

                                            <th width="5%" class="text-center">#</th>

                                            <th class="text-center">Seller</th>

                                            <th class="text-center">Bag Name</th>

                                            <th class="text-center">Total Bag</th>

                                            <th class="text-center">Total Weight</th>

                                            <th class="text-center">Booking Cost</th>

                                            <th class="text-center">Departure Date</th>

                                            <th class="text-center">Arrival Date</th>

                                            <th class="text-center">Status</th>

                                            <th width="15%" class="text-center">Action</th>

                                        </tr>

                                    </thead>

                                    <tbody >

                                        @forelse($sellings as $key=>$item)
                                            <tr >

                                                <td class="text-center">{{ $key + 1 }}</td>

                                                <td class="text-center">
                                                    {{ $item->seller->name ?? '-' }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $item->bag_name }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $item->total_quantity }}
                                                </td>

                                                <td class="text-center">
                                                    {{ $item->total_weight }}
                                                    {{ $item->unit }}
                                                </td>

                                                <td class="text-center">
                                                    ₹ {{ number_format($item->total_booking_cost, 2) }}
                                                </td>

                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($item->departure_date)->format('d/m/Y') }}
                                                </td>

                                                <td class="text-center">

                                                    @if ($item->expected_arrival_date)
                                                        {{ \Carbon\Carbon::parse($item->expected_arrival_date)->format('d/m/Y') }}
                                                    @else
                                                        -
                                                    @endif

                                                </td>

                                                <td class="text-center">

                                                    @if ($item->arrival && $item->arrival->attachment)
                                                        <span class="badge bg-success">
                                                            Completed
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            Pending
                                                        </span>
                                                    @endif

                                                </td>

                                                <td class="text-center">

                                                    <div class="btn-group">

                                                        @can('selling.view')
                                                            <a href="{{ route('admin.selling.show', $item->id) }}"
                                                                class="btn btn-info btn-sm">

                                                                <i class="fa fa-eye"></i>

                                                            </a>
                                                        @endcan

                                                        @can('selling.edit')
                                                            <a href="{{ route('admin.selling.edit', $item->id) }}"
                                                                class="btn btn-success btn-sm">

                                                                <i class="fa fa-edit"></i>

                                                            </a>
                                                        @endcan

                                                        @can('selling.delete')
                                                            <button data-id="{{ $item->id }}"
                                                                class="btn btn-danger btn-sm deleteData">

                                                                <i class="fa fa-trash"></i>

                                                            </button>
                                                        @endcan

                                                    </div>

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="10" class="text-center">
                                                    No Data Found
                                                </td>

                                            </tr>
                                        @endforelse

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
    </section>

@endsection

@push('scripts')

    <script>
        document.addEventListener("click", function(e) {
console.log('fdfdf');
            if (e.target.closest(".deleteData")) {
                let id = e.target.closest(".deleteData").dataset.id;
                Swal.fire({
                    title: "Are You Sure Want To Delete This Selling?",
                    text: "This action cannot be undone.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = "{{ route('admin.selling.destroy', ':id') }}";
                        url = url.replace(':id', id);
                        let form = document.getElementById('deleteForm');
                        form.action = url;
                        form.submit();
                    }
                })
            }
        })

        // $('#sellingTable').DataTable({
        //     responsive:true,
        //     pageLength:10,
        //     ordering:true
        // });

        $('#sellingTable').DataTable({
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
                targets: [8,9],
                orderable: false
            }]
        });
    </script>

@endpush
