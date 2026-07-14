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
                                    <div class="col-md-4 mb-3">
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
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Departure Date <span class="restrick">*</span>
                                        </label>

                                        <input type="date" class="form-control" name="departure_date"
                                            value="{{ old('departure_date', $selling->departure_date ?? '') }}">


                                        <small class="text-danger departure_date_error"></small>


                                    </div>

                                    {{-- Arrival Date --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Expected Arrival
                                        </label>

                                        <input type="date" class="form-control" name="expected_arrival_date"
                                            value="{{ old('expected_arrival_date', $selling->expected_arrival_date ?? '') }}">

                                        @error('expected_arrival_date')
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
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Total Bags <span class="restrick">*</span>
                                        </label>

                                        <input type="number" min="1" name="total_quantity" class="form-control"
                                            id="total_quantity"
                                            value="{{ old('total_quantity', $selling->total_quantity ?? '') }}">


                                        <small class="text-danger total_quantity_error"></small>

                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Booking Cost Per Bag <span class="restrick">*</span>
                                        </label>

                                        <input type="number" min="1" name="booking_cost_per_bag"
                                            class="form-control" id="booking_cost_per_bag"
                                            value="{{ old('booking_cost_per_bag', $selling->booking_cost_per_bag ?? '') }}">


                                        <small class="text-danger booking_cost_per_bag_error"></small>

                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Total Booking Cost
                                        </label>

                                        <input type="number" readonly step="0.01" min="0"
                                            name="total_booking_cost" id="total_booking_cost" class="form-control bg-light"
                                            value="{{ old('total_booking_cost', $selling->total_booking_cost ?? '0.00') }}">


                                        {{-- <small class="text-danger total_booking_cost_error"></small> --}}

                                    </div>

                                    {{-- Weight Per Bag --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Weight Per Bag <span class="restrick">*</span>
                                        </label>

                                        <input type="number" step="0.01" min="0" name="weight_per_bag"
                                            id="weight_per_bag" class="form-control"
                                            value="{{ old('weight_per_bag', $selling->weight_per_bag ?? '') }}">


                                        <small class="text-danger weight_per_bag_error"></small>

                                    </div>

                                    {{-- Unit --}}
                                    <div class="col-md-4 mb-3">
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


                        {{-- ===================== Departure Fish Details ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">

                                <h5 class="mb-0">
                                    <i class="fa-solid fa-fish me-2"></i>
                                    Departure Fish Details
                                </h5>

                                <button type="button" class="btn btn-light btn-sm" id="addDepartureFishRow">

                                    <i class="fa fa-plus"></i> Add Fish

                                </button>

                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered table-hover" id="departureFishTable">

                                        <thead class="table-light">

                                            <tr>

                                                <th width="22%" class="text-center">
                                                    Fish Name <span class="restrick">*</span>
                                                </th>

                                                <th width="15%" class="text-center">
                                                    Quantity(Bag) <span class="restrick">*</span>
                                                </th>

                                                <th width="15%" class="text-center">
                                                    Weight(Per Bag) <span class="restrick">*</span>
                                                </th>

                                                <th width="15%" class="text-center">
                                                    Unit <span class="restrick">*</span>
                                                </th>

                                                <th width="15%" class="text-center">
                                                    Total Weight
                                                </th>

                                                <th width="10%" class="text-center">
                                                    Action
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td>

                                                    <select name="departure_fish_id[]" class="form-select">

                                                        <option value="">Select Fish</option>

                                                        @foreach ($fish as $item)
                                                            <option value="{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                    <small class="text-danger departure_fish_id_error"></small>

                                                </td>

                                                <td>

                                                    <input type="number" class="form-control departure_quantity"
                                                        name="departure_quantity[]">

                                                    <small class="text-danger departure_quantity_error"></small>

                                                </td>

                                                <td>

                                                    <input type="number" class="form-control departure_weight"
                                                        step="0.01" name="departure_weight[]">

                                                    <small class="text-danger departure_weight_error"></small>

                                                </td>

                                                <td>

                                                    <select class="form-select" name="departure_unit[]">

                                                        <option value="KG">KG</option>
                                                        {{-- <option value="Gram">Gram</option>
                                                        <option value="Ton">Ton</option> --}}

                                                    </select>

                                                </td>

                                                <td>

                                                    <input type="number"
                                                        class="form-control departure_total_weight bg-light" readonly
                                                        name="departure_total_weight[]">
                                                </td>

                                                <td class="text-center">

                                                    <button type="button"
                                                        class="btn btn-danger btn-sm removeDepartureRow">

                                                        <i class="fa fa-trash"></i>

                                                    </button>

                                                </td>

                                            </tr>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                        {{-- departure fish summary --}}

                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-secondary text-white">

                                <h5 class="mb-0">
                                    Departure Summary
                                </h5>

                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-4">

                                        <label>Total Fish</label>

                                        <input type="text" readonly id="departure_total_fish"
                                            name="departure_total_fish" class="form-control bg-light" value="1">

                                    </div>

                                    <div class="col-md-4">

                                        <label>Total Quantity</label>

                                        <input type="text" readonly id="departure_total_quantity"
                                            name="departure_total_quantity" class="form-control bg-light" value="0">

                                    </div>

                                    <div class="col-md-4">

                                        <label>Total Weight</label>

                                        <input type="text" readonly id="departure_grand_total_weight"
                                            name="departure_grand_total_weight" class="form-control bg-light"
                                            value="0">

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- ===================== bill Information ===================== --}}
                        <div class="card shadow-sm border-0 mb-4">

                            <div class="card-header bg-warning">
                                <h5 class="mb-0 text-dark">
                                    <i class="fa-solid fa-truck-ramp-box me-2"></i>
                                    Bill Information
                                    <sup class="text-danger">
                                        Update the arrival date when the product reaches the seller. Fill in the billing
                                        details only after the bill is received.
                                    </sup>
                                </h5>
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    {{-- Arrival Date --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Arrival Date
                                        </label>

                                        <input type="date" name="arrival_date" class="form-control"
                                            value="{{ old('arrival_date', $selling->arrival_date ?? '') }}">


                                        <small class="text-danger arrival_date_error"></small>


                                    </div>


                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Billing Date
                                        </label>

                                        <input type="date" name="billing_date" class="form-control"
                                            value="{{ old('billing_date', $selling->billing_date ?? '') }}">


                                        <small class="text-danger billing_date_error"></small>


                                    </div>

                                    {{-- Attachment --}}
                                    <div class="col-md-4 mb-3">

                                        <label class="form-label fw-bold">
                                            Attachment Bill
                                        </label>

                                        <input type="file" name="attachment[]" class="form-control" id="attachment"
                                            accept=".jpg,.jpeg,.png,.pdf" multiple>

                                        <small class="text-danger attachment_error"></small>


                                        <small class="text-danger attachment_error"></small>


                                        @if (isset($selling) && !empty($selling->attachment))
                                            <div class="mt-2">
                                                <a href="{{ asset('storage/' . $selling->attachment) }}" target="_blank"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-eye"></i> View Current Attachment
                                                </a>
                                            </div>
                                        @endif

                                    </div>

                                    <div class="mt-3" id="billPreview" style="display:none;">

                                        <div class="row" id="previewContainer"></div>

                                        <button type="button" class="btn btn-danger btn-sm mt-3" id="removeBillFile"
                                            style="display:none;">
                                            <i class="fa fa-trash"></i> Remove All
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div id="billSection" class="d-none">

                            {{-- ===================== Bill Fish Details ===================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div
                                    class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>
                                        Bill Fish Details
                                    </h5>

                                    <button type="button" class="btn btn-light btn-sm" id="addBillFishRow">
                                        <i class="fa fa-plus me-1"></i> Add Fish
                                    </button>

                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table class="table table-bordered table-hover mb-0" id="billFishTable">

                                            <thead class="table-primary">

                                                <tr style="font-size: small;">
                                                    <th width="20%" class="text-center"> Fish Name <span
                                                            class="restrick">*</span> </th>
                                                    <th width="12%" class="text-center"> Quantity(Bag) <span
                                                            class="restrick">*</span> </th>
                                                    <th width="12%" class="text-center"> Weight(Per Bag) <span
                                                            class="restrick">*</span> </th>
                                                    <th width="10%" class="text-center"> Unit <span
                                                            class="restrick">*</span> </th>
                                                    <th width="12%" class="text-center"> Price <span
                                                            class="restrick">*</span> </th>
                                                    <th width="12%" class="text-center"> Total Weight </th>
                                                    <th width="14%" class="text-center"> Total Price </th>
                                                    <th width="10%" class="text-center"> Action </th>
                                                </tr>

                                            </thead>

                                            <tbody>

                                                <tr>

                                                    {{-- Fish --}}
                                                    <td>

                                                        <select name="bill_fish_id[]" class="form-select form-select-sm">

                                                            <option value="">Select Fish</option>

                                                            @foreach ($fish as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                        <small class="text-danger bill_fish_id_error"></small>

                                                    </td>

                                                    {{-- Quantity --}}
                                                    <td>

                                                        <input type="number" name="bill_quantity[]"
                                                            class="form-control form-control-sm bill_quantity"
                                                            placeholder="Qty">

                                                        <small class="text-danger bill_quantity_error"></small>

                                                    </td>

                                                    {{-- Weight --}}
                                                    <td>

                                                        <input type="number" step="0.01" name="bill_weight[]"
                                                            class="form-control form-control-sm bill_weight"
                                                            placeholder="Weight">

                                                        <small class="text-danger bill_weight_error"></small>

                                                    </td>

                                                    {{-- Unit --}}
                                                    <td>

                                                        <select name="bill_unit[]" class="form-select form-select-sm">

                                                            <option value="KG">KG</option>

                                                        </select>

                                                        <small class="text-danger bill_unit_error"></small>

                                                    </td>

                                                    {{-- Price --}}
                                                    <td>

                                                        <div class="input-group input-group-sm">

                                                            <span class="input-group-text">₹</span>

                                                            <input type="number" step="0.01" name="bill_price[]"
                                                                class="form-control bill_price" placeholder="0.00">

                                                        </div>

                                                        <small class="text-danger bill_price_error"></small>

                                                    </td>

                                                    {{-- Total Weight --}}
                                                    <td>

                                                        <input type="number" readonly
                                                            class="form-control form-control-sm bg-light bill_total_weight"
                                                            name="bill_total_weight[]">

                                                    </td>

                                                    {{-- Total Price --}}
                                                    <td>

                                                        <input type="number" readonly
                                                            class="form-control form-control-sm bg-light fw-bold bill_total_price"
                                                            name="bill_total_price[]">

                                                    </td>

                                                    {{-- Remove --}}
                                                    <td class="text-center">

                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm removeBillRow">
                                                            <i class="fa fa-trash"></i>
                                                        </button>

                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>


                            {{-- =====================Bill Summary ===================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-success text-white">

                                    <h5 class="mb-0">
                                        <i class="fa-solid fa-calculator me-2"></i>
                                        Bill Summary
                                    </h5>

                                </div>

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-3 mb-3">

                                            <label class="form-label fw-bold">
                                                Grand Total
                                            </label>

                                            <input type="number" readonly id="bill_grand_total" name="grand_total"
                                                class="form-control bg-light" value="0.00">

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <label class="form-label fw-bold">
                                                Total Weight
                                            </label>

                                            <input type="number" readonly id="bill_grand_total_weight"
                                                name="bill_grand_total_weight" class="form-control bg-light"
                                                value="0">

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <label class="form-label fw-bold">
                                                Fish Items
                                            </label>

                                            <input type="number" readonly id="bill_total_fish" name="bill_total_fish"
                                                class="form-control bg-light" value="1">

                                        </div>

                                        <div class="col-md-3 mb-3">

                                            <label class="form-label fw-bold">
                                                Total Quantity
                                            </label>

                                            <input type="number" readonly id="bill_total_quantity"
                                                name="bill_total_quantity" class="form-control bg-light" value="0">

                                        </div>

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


    {{-- <script>
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

                $('.weight').each(function() {
                    totalWeight += parseFloat($(this).val()) || 0;
                });

                $('#total_weight').val(totalWeight.toFixed(2));
                // $('#grand_total').val(grand.toFixed(2));
                $('#all_quantity').val(totalQty);
                $('#total_fish').val($('#fishTable tbody tr').length);

            }

        });
    </script> --}}


    <script>
        // $(function() {

        /*====================================================
            DEPARTURE FISH
        ====================================================*/

        $(document).on('keyup change', '#total_quantity, #booking_cost_per_bag', function() {

            let totalQty = parseFloat($('#total_quantity').val()) || 0;
            let bookingCost = parseFloat($('#booking_cost_per_bag').val()) || 0;

            $('#total_booking_cost').val((totalQty * bookingCost).toFixed(2));

        });

        $('#addDepartureFishRow').click(function() {

            let row = $('#departureFishTable tbody tr:first').clone();

            row.find('input').val('');
            row.find('select').prop('selectedIndex', 0);

            $('#departureFishTable tbody').append(row);

            calculateDepartureSummary();

        });


        $(document).on('click', '.removeDepartureRow', function() {

            if ($('#departureFishTable tbody tr').length > 1) {

                $(this).closest('tr').remove();

                calculateDepartureSummary();

            }

        });


        $(document).on('keyup change',
            '.departure_quantity,.departure_weight',

            function() {
                let row = $(this).closest('tr');
                let depar_weight = parseFloat(row.find('.departure_weight').val()) || 0;
                let depar_qty = parseFloat(row.find('.departure_quantity').val()) || 0;
                let total_weight = depar_weight * depar_qty;

                row.find('.departure_total_weight').val(total_weight.toFixed(2));

                calculateDepartureSummary();

            }
        );


        function calculateDepartureSummary() {

            let totalQty = 0;
            let totalWeight = 0;

            $('.departure_quantity').each(function() {

                totalQty += parseFloat($(this).val()) || 0;

            });

            $('.departure_total_weight').each(function() {

                totalWeight += parseFloat($(this).val()) || 0;

            });

            $('#departure_total_quantity').val(totalQty);

            $('#departure_grand_total_weight').val(totalWeight.toFixed(2));

            $('#departure_total_fish').val(
                $('#departureFishTable tbody tr').length
            );

        }






        /*====================================================
            BILL FISH
        ====================================================*/

        $('#addBillFishRow').click(function() {

            let row = $('#billFishTable tbody tr:first').clone();

            row.find('input').val('');
            row.find('select').prop('selectedIndex', 0);

            $('#billFishTable tbody').append(row);

            calculateBillSummary();

        });


        $(document).on('click', '.removeBillRow', function() {

            if ($('#billFishTable tbody tr').length > 1) {

                $(this).closest('tr').remove();

                calculateBillSummary();

            }

        });


        $(document).on(
            'keyup change',
            '.bill_quantity,.bill_weight,.bill_price',
            function() {

                let row = $(this).closest('tr');

                let qty = parseFloat(row.find('.bill_quantity').val()) || 0;
                let weight = parseFloat(row.find('.bill_weight').val()) || 0;

                let price = parseFloat(row.find('.bill_price').val()) || 0;

                let totalweight = qty * weight;

                row.find('.bill_total_weight').val(totalweight.toFixed(2));


                row.find('.bill_total_price').val(
                    (totalweight * price).toFixed(2)
                );

                calculateBillSummary();

            }
        );


        function calculateBillSummary() {

            let grand = 0;
            let totalQty = 0;
            let totalWeight = 0;

            $('.bill_total_price').each(function() {

                grand += parseFloat($(this).val()) || 0;

            });

            $('.bill_quantity').each(function() {

                totalQty += parseFloat($(this).val()) || 0;

            });

            $('.bill_total_weight').each(function() {

                totalWeight += parseFloat($(this).val()) || 0;

            });

            $('#bill_grand_total').val(grand.toFixed(2));

            $('#bill_total_quantity').val(totalQty);

            $('#bill_grand_total_weight').val(totalWeight.toFixed(2));

            $('#bill_total_fish').val(
                $('#billFishTable tbody tr').length
            );

        };

        // });
    </script>

    <script>
        // $(document).ready(function() {

        //     $('input[name="attachment"]').on('change', function() {

        //         let file = this.files[0];

        //         if (!file) {

        //             $('#billSection').addClass('d-none');

        //             $('#billPreview').hide();

        //             return;

        //         }

        //         $('#billSection').removeClass('d-none');

        //         $('#billPreview').show();

        //         let extension = file.name.split('.').pop().toLowerCase();

        //         if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {

        //             let reader = new FileReader();

        //             reader.onload = function(e) {

        //                 $('#billPreviewImage')
        //                     .attr('src', e.target.result)
        //                     .show();

        //                 $('#pdfPreview').hide();

        //             };

        //             reader.readAsDataURL(file);

        //         } else if (extension === 'pdf') {

        //             $('#billPreviewImage').hide();

        //             $('#pdfPreview').show();

        //             $('#pdfFileName').text(file.name);

        //         }

        //     });

        // });

        $(function () {

    $('#attachment').on('change', function () {

        let files = this.files;

        if (!files.length) return;

        $('#billSection').removeClass('d-none');
        $('#billPreview').show();
        $('#removeBillFile').show();

        $('#previewContainer').html('');

        $.each(files, function (index, file) {

            let extension = file.name.split('.').pop().toLowerCase();

            if (['jpg','jpeg','png','gif','webp'].includes(extension)) {

                let reader = new FileReader();

                reader.onload = function (e) {

                    $('#previewContainer').append(`
                        <div class="col-md-3 mb-3 text-center">

                            <img src="${e.target.result}"
                                 class="img-thumbnail"
                                 style="height:180px;width:100%;object-fit:cover;">

                            <small class="d-block mt-2">${file.name}</small>

                        </div>
                    `);

                };

                reader.readAsDataURL(file);

            } else if (extension === 'pdf') {

                $('#previewContainer').append(`
                    <div class="col-md-3 mb-3">

                        <div class="border rounded p-4 text-center">

                            <i class="fa fa-file-pdf fa-3x text-danger"></i>

                            <p class="small mt-2 mb-0">${file.name}</p>

                        </div>

                    </div>
                `);

            }

        });

    });

    // Remove All
    $('#removeBillFile').click(function () {

        $('#attachment').val('');

        $('#previewContainer').html('');

        $('#billPreview').hide();

        $('#removeBillFile').hide();

        $('#billSection').addClass('d-none');

    });

});
    </script>
@endpush
