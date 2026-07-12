@extends('layouts.admin.master')

@section('title')
    Selling Management
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
                                        <a href="{{ route('admin.selling.index') }}">Selling List</a>
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

                    <form
                        action="{{ isset($selling) ? route('admin.selling.update', $selling->id) : route('admin.selling.store') }}"
                        method="POST" enctype="multipart/form-data" class="ajax-form">

                        @csrf

                        @if (isset($selling))
                            @method('PUT')
                        @endif

                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-user me-2"></i>
                                    Seller Information
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- Seller --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            Seller
                                            <span class="restrick">*</span>
                                        </label>

                                        <select name="seller_id" class="form-select select2">

                                            <option value="">Select Seller</option>

                                            @foreach ($selleruser as $seller)
                                                <option value="{{ $seller->id }}"
                                                    {{ old('seller_id', $selling->seller_id ?? '') == $seller->id ? 'selected' : '' }}>

                                                    {{ $seller->name }}

                                                </option>
                                            @endforeach

                                        </select>


                                        <small class="text-danger seller_id_error"></small>


                                    </div>

                                    {{-- Departure Date --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="form-label fw-bold">
                                            Departure Date <span class="restrick">*</span>
                                        </label>

                                        <input type="date" class="form-control" name="departure_date"
                                            value="{{ old('departure_date', $selling->departure_date ?? '') }}">


                                        <small class="text-danger departure_date_error"></small>


                                    </div>

                                    {{-- Arrival Date --}}
                                    <div class="col-md-3 mb-3">

                                        <label class="form-label fw-bold">
                                            Expected Arrival
                                        </label>

                                        <input type="date" class="form-control" name="arrival_date"
                                            value="{{ old('arrival_date', $selling->arrival_date ?? '') }}">

                                        @error('arrival_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ===================== Bag Information ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-box me-2"></i>
                                    Bag Information
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- Bag Name --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Bag Name
                                            <span class="restrick">*</span>
                                        </label>

                                        <input type="text" name="bag_name" class="form-control"
                                            placeholder="Enter Bag Name"
                                            value="{{ old('bag_name', $selling->bag_name ?? '') }}">


                                        <small class="text-danger bag_name_error"></small>

                                    </div>

                                    {{-- Total Quantity --}}
                                    <div class="col-md-2 mb-3">
                                        <label class="form-label fw-bold">
                                            Total Bags <span class="restrick">*</span>
                                        </label>

                                        <input type="number" min="1" name="total_quantity" class="form-control"
                                            id="total_quantity"
                                            value="{{ old('total_quantity', $selling->total_quantity ?? '') }}">


                                        <small class="text-danger"></small>

                                    </div>

                                    {{-- Weight Per Bag --}}
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">
                                            Weight Per Bag <span class="restrick">*</span>
                                        </label>

                                        <input type="number" step="0.01" min="0" name="weight_per_bag"
                                            id="weight_per_bag" class="form-control"
                                            value="{{ old('weight_per_bag', $selling->weight_per_bag ?? '') }}">


                                        <small class="text-danger weight_per_bag_error"></small>

                                    </div>

                                    {{-- Unit --}}
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label fw-bold">
                                            Unit <span class="restrick">*</span>
                                        </label>

                                        <select name="unit" id="unit" class="form-select">

                                            <option value="">Select Unit </option>

                                            <option value="KG"
                                                {{ old('unit', $selling->unit ?? '') == 'KG' ? 'selected' : '' }}>
                                                KG
                                            </option>

                                            {{-- <option value="Gram"
                                                {{ old('unit', $selling->unit ?? '') == 'Gram' ? 'selected' : '' }}>
                                                Gram
                                            </option>

                                            <option value="Ton"
                                                {{ old('unit', $selling->unit ?? '') == 'Ton' ? 'selected' : '' }}>
                                                Ton
                                            </option> --}}

                                        </select>


                                        <small class="text-danger unit_error"></small>

                                    </div>

                                </div>

                                <div class="row">

                                    {{-- Total Weight --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Total Weight
                                        </label>

                                        <input type="number" readonly step="0.01" id="total_weight"
                                            name="total_weight" class="form-control bg-light"
                                            value="{{ old('total_weight', $selling->total_weight ?? '') }}">

                                        @error('total_weight')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ===================== Fish Details ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-fish me-2"></i>
                                    Fish Details
                                </h5>

                                <button type="button" class="btn btn-light btn-sm" id="addFishRow">
                                    <i class="fa fa-plus"></i> Add Fish
                                </button>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover align-middle" id="fishTable">

                                        <thead class="table-light">

                                            <tr>

                                                <th width="22%" class="text-center">Fish Name <span
                                                        class="restrick">*</span></th>

                                                <th width="10%" class="text-center">Quantity <span
                                                        class="restrick">*</span></th>

                                                <th width="12%" class="text-center">Weight <span
                                                        class="restrick">*</span></th>

                                                <th width="12%" class="text-center">Unit <span
                                                        class="restrick">*</span></th>

                                                <th width="12%" class="text-center">Price</th>

                                                <th width="15%" class="text-center">Total Price</th>

                                                <th width="8%" class="text-center">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr>

                                                {{-- Fish --}}
                                                <td>

                                                    <select name="fish_id[]" class="form-select">

                                                        <option value="">Select Fish</option>

                                                        @foreach ($fish as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <small class="text-danger fish_id_error"></small>


                                                </td>

                                                {{-- Quantity --}}
                                                <td>

                                                    <input type="number" class="form-control quantity" name="quantity[]"
                                                        min="0">
                                                    <small class="text-danger quantity_error"></small>

                                                </td>

                                                {{-- Weight --}}
                                                <td>

                                                    <input type="number" class="form-control weight" step="0.01"
                                                        name="weight[]">
                                                    <small class="text-danger weight_error"></small>
                                                </td>

                                                {{-- Unit --}}
                                                <td>

                                                    <select name="fish_unit[]" class="form-select">

                                                        <option value="KG">KG</option>

                                                        {{-- <option value="Gram">Gram</option>

                                                        <option value="Ton">Ton</option> --}}

                                                    </select>

                                                </td>

                                                {{-- Price --}}
                                                <td>

                                                    <input type="number" class="form-control price" step="0.01"
                                                        name="price[]">

                                                </td>

                                                {{-- Total --}}
                                                <td>

                                                    <input type="number" readonly
                                                        class="form-control total_price bg-light" name="total_price[]">

                                                </td>

                                                {{-- Remove --}}
                                                <td class="text-center">

                                                    <button type="button" class="btn btn-danger btn-sm removeRow">

                                                        <i class="fa fa-trash"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>


                        {{-- ===================== bill Information ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-warning">
                                <h5 class="mb-0 text-dark">
                                    <i class="fa-solid fa-truck-ramp-box me-2"></i>
                                    Bill Information
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- Arrival Date --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">
                                            Arrival Date
                                        </label>

                                        <input type="date" name="arrival_date" class="form-control"
                                            value="{{ old('arrival_date', $selling->arrival_date ?? '') }}">

                                        @error('arrival_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                    </div>

                                    {{-- Attachment --}}
                                    <div class="col-md-6 mb-3">

                                        <label class="form-label fw-bold">
                                            Attachment Bill
                                        </label>

                                        <input type="file" name="attachment" class="form-control"
                                            accept=".jpg,.jpeg,.png,.pdf">

                                        @error('attachment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        @if (isset($selling) && !empty($selling->attachment))
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $selling->attachment) }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-eye"></i> View Current Attachment
                                                </a>
                                            </div>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ===================== Summary ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">
                                    <i class="fa-solid fa-calculator me-2"></i>
                                    Summary
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- Grand Total --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Grand Total
                                        </label>

                                        <input type="number" id="grand_total" class="form-control bg-light" readonly
                                            value="0.00">

                                    </div>

                                    {{-- Total Fish --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Total Fish Items
                                        </label>

                                        <input type="text" id="total_fish" class="form-control bg-light" readonly
                                            value="1">

                                    </div>

                                    {{-- Total Quantity --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Total Quantity
                                        </label>

                                        <input type="text" id="all_quantity" class="form-control bg-light" readonly
                                            value="0">

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ===================== Buttons ===================== --}}
                        <div class="card shadow-sm border-0">

                            <div class="card-body">

                                <div class="d-flex justify-content-end">

                                    <a href="{{ route('admin.selling.index') }}" class="btn btn-secondary me-2">

                                        <i class="fa fa-arrow-left"></i>
                                        Back

                                    </a>

                                    <button type="reset" class="btn btn-warning me-2">

                                        <i class="fa fa-rotate-left"></i>
                                        Reset

                                    </button>

                                    <button type="submit" class="btn btn-success">

                                        <i class="fa fa-save"></i>

                                        {{ isset($selling) ? 'Update Selling' : 'Save Selling' }}

                                    </button>

                                </div>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            function calculateWeight() {

                let totalBag = parseFloat($('#total_quantity').val()) || 0;
                let weightPerBag = parseFloat($('#weight_per_bag').val()) || 0;

                let totalWeight = totalBag * weightPerBag;

                $('#total_weight').val(totalWeight.toFixed(2));
            }

            $('#total_quantity, #weight_per_bag').on('keyup change', function() {
                calculateWeight();
            });

            calculateWeight();

        });
    </script>


    <script>
        $(function() {

            // Add New Row
            $('#addFishRow').click(function() {

                let row = $('#fishTable tbody tr:first').clone();

                row.find('input').val('');

                row.find('select').prop('selectedIndex', 0);

                $('#fishTable tbody').append(row);
                calculateGrandTotal();
            });

            // Remove Row
            $(document).on('click', '.removeRow', function() {

                if ($('#fishTable tbody tr').length > 1) {

                    $(this).closest('tr').remove();

                    calculateGrandTotal();

                }

            });

            // Total Price

            $(document).on('keyup change', '.quantity,.price', function() {

                let row = $(this).closest('tr');

                let qty = parseFloat(row.find('.quantity').val()) || 0;

                let price = parseFloat(row.find('.price').val()) || 0;

                row.find('.total_price').val((qty * price).toFixed(2));

                calculateGrandTotal();

            });

            function calculateGrandTotal() {

                let grand = 0;
                let totalQty = 0;

                $('.total_price').each(function() {
                    grand += parseFloat($(this).val()) || 0;
                });

                $('.quantity').each(function() {
                    totalQty += parseFloat($(this).val()) || 0;
                });

                $('#grand_total').val(grand.toFixed(2));
                $('#all_quantity').val(totalQty);
                $('#total_fish').val($('#fishTable tbody tr').length);

            }

        });
    </script>

    <script>
        // function calculateGrandTotal() {

        //     let grand = 0;
        //     let totalQty = 0;

        //     $('.total_price').each(function() {
        //         grand += parseFloat($(this).val()) || 0;
        //     });

        //     $('.quantity').each(function() {
        //         totalQty += parseFloat($(this).val()) || 0;
        //     });

        //     $('#grand_total').val(grand.toFixed(2));
        //     $('#all_quantity').val(totalQty);
        //     $('#total_fish').val($('#fishTable tbody tr').length);

        // }

        // $('#addFishRow').click(function() {

        //     let row = $('#fishTable tbody tr:first').clone();

        //     row.find('input').val('');
        //     row.find('select').prop('selectedIndex', 0);

        //     $('#fishTable tbody').append(row);

        //     calculateGrandTotal();

        // });

        // $(document).on('click', '.removeRow', function() {

        //     if ($('#fishTable tbody tr').length > 1) {

        //         $(this).closest('tr').remove();

        //         calculateGrandTotal();

        //     }

        // });
    </script>
@endpush
