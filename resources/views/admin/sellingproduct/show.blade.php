@extends('layouts.admin.master')

@section('title')
    Selling Details
@endsection

@section('content')

    <section class="section">

        <div class="container-fluid">

            {{-- ================= Title ================= --}}
            <div class="title-wrapper pt-30">

                <div class="row align-items-center">

                    <div class="col-md-6">

                        <div class="title">

                            <h2>
                                <i class="fa-solid fa-truck-fast text-primary"></i>
                                Selling Details
                            </h2>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="breadcrumb-wrapper">

                            <nav aria-label="breadcrumb">

                                <ol class="breadcrumb">

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">
                                            Dashboard
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.selling.index') }}">
                                            Selling List
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        View Details
                                    </li>

                                </ol>

                            </nav>

                        </div>

                    </div>

                </div>

            </div>



            {{-- ================= Action Buttons ================= --}}

            <div class="row mb-4">

                <div class="col-md-12 text-end">

                    @can('selling.edit')
                        <a href="{{ route('admin.selling.edit', $selling->id) }}" class="btn btn-success">

                            <i class="fa fa-edit"></i>
                            Edit

                        </a>
                    @endcan

                    <a href="{{ route('admin.selling.index') }}" class="btn btn-secondary">

                        <i class="fa fa-arrow-left"></i>
                        Back

                    </a>

                </div>

            </div>


            {{-- ================= Seller & Departure Information ================= --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">
                        <i class="fa-solid fa-user me-2"></i>
                        Seller & Departure Information
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Seller --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Seller Name
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ $selling->seller->name ?? '-' }}">

                        </div>

                        {{-- Bag Name --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Bag Name
                            </label>

                            <input type="text" class="form-control bg-light" readonly value="{{ $selling->bag_name }}">

                        </div>

                        {{-- Total Bag --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Total Quantity (Bag)
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ $selling->total_quantity }}">

                        </div>

                        {{-- Weight Per Bag --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Weight Per Bag
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ $selling->weight_per_bag }} {{ $selling->unit }}">

                        </div>

                        {{-- Total Weight --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Total Weight
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ $selling->total_weight }} {{ $selling->unit }}">

                        </div>

                        {{-- Booking Cost --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Booking Cost / Bag
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="₹ {{ number_format($selling->booking_cost_per_bag, 2) }}">

                        </div>

                        {{-- Total Booking Cost --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Total Booking Cost
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="₹ {{ number_format($selling->total_booking_cost, 2) }}">

                        </div>

                        {{-- Departure Date --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Departure Date
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ \Carbon\Carbon::parse($selling->departure_date)->format('d/m/Y') }}">

                        </div>

                        {{-- Expected Arrival Date --}}
                        <div class="col-md-4 mb-3">

                            <label class="form-label fw-bold">
                                Expected Arrival Date
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ $selling->expected_arrival_date ? \Carbon\Carbon::parse($selling->expected_arrival_date)->format('d/m/Y') : '-' }}">

                        </div>

                    </div>

                </div>

            </div>

            {{-- ===================== Departure Fish Details ===================== --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-info text-white">

                    <h5 class="mb-0">
                        <i class="fa-solid fa-fish me-2"></i>
                        Departure Fish Details
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th width="8%" class="text-center">#</th>

                                    <th>Fish Name</th>

                                    <th class="text-center">Quantity (Bag)</th>

                                    <th class="text-center">Weight / Bag</th>

                                    <th class="text-center">Unit</th>

                                    <th class="text-center">Total Weight</th>

                                </tr>

                            </thead>

                            <tbody>

                                @php
                                    $departureWeight = 0;
                                    $departureQty = 0;
                                @endphp

                                @forelse($selling->fishes as $key => $fish)
                                    @if ($fish->departure_fish_id)
                                        @php
                                            $departureWeight = $fish->departure_grand_total_weight;
                                            $departureQty = $fish->departure_total_quantity;
                                        @endphp

                                        <tr>

                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>

                                            <td>
                                                {{ $fish->departureFish->name ?? '-' }}
                                            </td>

                                            <td class="text-center">
                                                {{ $fish->departure_quantity }}
                                            </td>

                                            <td class="text-center">
                                                {{ $fish->departure_weight }}
                                            </td>

                                            <td class="text-center">
                                                {{ $fish->departure_unit }}
                                            </td>

                                            <td class="text-center fw-bold">
                                                {{ number_format($fish->departure_total_weight, 2) }}
                                            </td>

                                        </tr>
                                    @endif

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center text-muted">
                                            No Departure Fish Found.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                            <tfoot class="table-secondary">

                                <tr>

                                    <th colspan="2" class="text-end">
                                        Total
                                    </th>

                                    <th class="text-center">
                                        {{ $departureQty }}
                                    </th>

                                    <th></th>

                                    <th></th>

                                    <th class="text-center">
                                        {{ number_format($departureWeight, 2) }}
                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>

            {{-- ===================== Departure Summary ===================== --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-secondary text-white">

                    <h5 class="mb-0">
                        <i class="fa-solid fa-chart-column me-2"></i>
                        Departure Summary
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Total Fish --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow-sm bg-primary text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-fish fa-2x mb-2"></i>

                                    <h6>Total Fish Items</h6>

                                    <h3 class="fw-bold">
                                        {{ $selling->fishes->whereNotNull('departure_fish_id')->count() }}
                                    </h3>

                                </div>

                            </div>

                        </div>

                        {{-- Total Quantity --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow-sm bg-success text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-boxes-stacked fa-2x mb-2"></i>

                                    <h6>Total Quantity</h6>

                                    <h3 class="fw-bold">
                                        {{ $selling->total_quantity }}
                                    </h3>

                                    <small>Bags</small>

                                </div>

                            </div>

                        </div>

                        {{-- Total Weight --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow-sm bg-info text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-weight-hanging fa-2x mb-2"></i>

                                    <h6>Total Weight</h6>

                                    <h3 class="fw-bold">
                                        {{ number_format($selling->total_weight, 2) }}
                                    </h3>

                                    <small>{{ $selling->unit }}</small>

                                </div>

                            </div>

                        </div>

                        {{-- Booking Cost --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow-sm bg-warning text-dark h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-indian-rupee-sign fa-2x mb-2"></i>

                                    <h6>Total Booking Cost</h6>

                                    <h3 class="fw-bold">

                                        ₹ {{ number_format($selling->total_booking_cost, 2) }}

                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ===================== Bill Information ===================== --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-warning">

                    <h5 class="mb-0 text-dark">

                        <i class="fa-solid fa-file-invoice-dollar me-2"></i>

                        Bill Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Arrival Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label fw-bold">
                                Arrival Date
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ optional($selling->arrival)->arrival_date ? \Carbon\Carbon::parse($selling->arrival->arrival_date)->format('d/m/Y') : '-' }}">

                        </div>

                        {{-- Billing Date --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label fw-bold">
                                Billing Date
                            </label>

                            <input type="text" class="form-control bg-light" readonly
                                value="{{ optional($selling->arrival)->billing_date ? \Carbon\Carbon::parse($selling->arrival->billing_date)->format('d/m/Y') : '-' }}">

                        </div>

                        {{-- Bill Status --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label fw-bold">
                                Bill Status
                            </label>

                            <div class="mt-2">

                                @if (!empty(optional($selling->arrival)->attachment))
                                    <span class="badge bg-success fs-6">
                                        <i class="fa fa-check-circle"></i>
                                        Bill Received
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fa fa-clock"></i>
                                        Pending
                                    </span>
                                @endif

                            </div>

                        </div>

                        {{-- Attachment --}}
                        <div class="col-12 mb-3">

                            <label class="form-label fw-bold">
                                Bill Attachments
                            </label>

                            @php
                                $attachments = [];

                                if (!empty(optional($selling->arrival)->attachment)) {
                                    $attachments = json_decode($selling->arrival->attachment, true);

                                    if (!is_array($attachments)) {
                                        $attachments = [$selling->arrival->attachment];
                                    }
                                }
                            @endphp

                            @if (count($attachments))
                                <div class="row">

                                    @foreach ($attachments as $file)
                                        @php
                                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        @endphp

                                        <div class="col-md-3 mb-3">

                                            <div class="card shadow-sm h-100">

                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                                    <a href="{{ asset('storage/bill/attachment/' . $file) }}"
                                                        target="_blank">

                                                        <img src="{{ asset('storage/bill/attachment/' . $file) }}"
                                                            class="card-img-top" style="height:180px;object-fit:cover;">

                                                    </a>
                                                @elseif($extension == 'pdf')
                                                    <div class="text-center py-5">

                                                        <i class="fa-solid fa-file-pdf fa-4x text-danger"></i>

                                                        <p class="mt-2 mb-0">
                                                            PDF Document
                                                        </p>

                                                    </div>
                                                @else
                                                    <div class="text-center py-5">

                                                        <i class="fa-solid fa-file fa-4x text-secondary"></i>

                                                        <p class="mt-2 mb-0">
                                                            File
                                                        </p>

                                                    </div>
                                                @endif

                                                <div class="card-footer text-center">

                                                    <a href="{{ asset('storage/bill/attachment/' . $file) }}"
                                                        target="_blank" class="btn btn-primary btn-sm">

                                                        <i class="fa fa-eye"></i> View

                                                    </a>

                                                    <a href="{{ asset('storage/bill/attachment/' . $file) }}" download
                                                        class="btn btn-success btn-sm">

                                                        <i class="fa fa-download"></i> Download

                                                    </a>

                                                </div>

                                            </div>

                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="alert alert-light border text-center mb-0">

                                    <i class="fa fa-file-circle-xmark text-danger"></i>

                                    No Bill Attachments Available

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- ===================== Bill Fish Details ===================== --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-success text-white">

                    <h5 class="mb-0">
                        <i class="fa-solid fa-fish me-2"></i>
                        Bill Fish Details
                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light">

                                <tr>

                                    <th width="5%" class="text-center">#</th>

                                    <th>Fish Name</th>

                                    <th class="text-center">Quantity (Bag)</th>

                                    <th class="text-center">Weight / Bag</th>

                                    <th class="text-center">Unit</th>

                                    <th class="text-center">Price</th>

                                    <th class="text-center">Total Weight</th>

                                    <th class="text-center">Total Price</th>

                                </tr>

                            </thead>

                            <tbody>

                                @php

                                    $billQty = 0;
                                    $billWeight = 0;
                                    $grandTotal = 0;
                                    $totalfish = 0;

                                @endphp

                                @forelse($selling->fishes  as $key=> $fish)
                                    @if ($fish->arrival_fish_id)
                                        @php

                                            $billQty = $fish->bill_total_quantity;
                                            $billWeight = $fish->bill_grand_total_weight;
                                            $grandTotal = $fish->grand_total;
                                            $totalfish = $fish->bill_total_fish;

                                        @endphp

                                        <tr>

                                            <td class="text-center">
                                                {{ $key + 1 }}
                                            </td>

                                            <td>
                                                {{ $fish->arrivalFish->name ?? '-' }}
                                            </td>

                                            <td class="text-center">
                                                {{ $fish->bill_quantity }}
                                            </td>

                                            <td class="text-center">
                                                {{ number_format($fish->bill_weight, 2) }}
                                            </td>

                                            <td class="text-center">
                                                {{ $fish->bill_unit }}
                                            </td>

                                            <td class="text-end">
                                                ₹ {{ number_format($fish->bill_price, 2) }}
                                            </td>

                                            <td class="text-center">
                                                {{ number_format($fish->bill_total_weight, 2) }}
                                            </td>

                                            <td class="text-end fw-bold text-success">
                                                ₹ {{ number_format($fish->bill_total_price, 2) }}
                                            </td>

                                        </tr>
                                    @endif

                                @empty

                                    <tr>

                                        <td colspan="8" class="text-center text-muted">

                                            No Bill Fish Details Available

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                            <tfoot class="table-secondary">

                                <tr>

                                    <th colspan="2" class="text-end">

                                        Total

                                    </th>

                                    <th class="text-center">

                                        {{ $billQty }}

                                    </th>

                                    <th></th>

                                    <th></th>

                                    <th></th>

                                    <th class="text-center">

                                        {{ number_format($billWeight, 2) }}

                                    </th>

                                    <th class="text-end">

                                        ₹ {{ number_format($grandTotal, 2) }}

                                    </th>

                                </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div>


            {{-- ===================== Bill Summary ===================== --}}
            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-secondary text-white">

                    <h5 class="mb-0">
                        <i class="fa-solid fa-chart-pie me-2"></i>
                        Bill Summary
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- Grand Total --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow bg-success text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-indian-rupee-sign fa-2x mb-2"></i>

                                    <h6>Grand Total</h6>

                                    <h3 class="fw-bold">

                                        ₹ {{ number_format($grandTotal, 2) }}

                                    </h3>

                                </div>

                            </div>

                        </div>

                        {{-- Total Fish --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow bg-primary text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-fish fa-2x mb-2"></i>

                                    <h6>Total Fish Items</h6>

                                    <h3 class="fw-bold">

                                        {{ $totalfish }}

                                    </h3>

                                </div>

                            </div>

                        </div>

                        {{-- Total Quantity --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow bg-warning text-dark h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-boxes-stacked fa-2x mb-2"></i>

                                    <h6>Total Quantity</h6>

                                    <h3 class="fw-bold">

                                        {{ $billQty }}

                                    </h3>

                                    <small>Bags</small>

                                </div>

                            </div>

                        </div>

                        {{-- Total Weight --}}
                        <div class="col-lg-3 col-md-6 mb-3">

                            <div class="card border-0 shadow bg-info text-white h-100">

                                <div class="card-body text-center">

                                    <i class="fa-solid fa-weight-hanging fa-2x mb-2"></i>

                                    <h6>Total Weight</h6>

                                    <h3 class="fw-bold">

                                        {{ number_format($billWeight, 2) }}

                                    </h3>

                                    <small>{{ $selling->unit }}</small>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ===================== Bill Attachment ===================== --}}
            {{-- <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-warning">
                    <h5 class="mb-0 text-dark">
                        <i class="fa-solid fa-file-invoice me-2"></i>
                        Bill Attachments
                    </h5>
                </div>

                <div class="card-body">

                    @php
                        $attachments = [];

                        if (!empty($arrival->attachment)) {
                            $attachments = json_decode($arrival->attachment, true);

                            if (!is_array($attachments)) {
                                $attachments = [$arrival->attachment];
                            }
                        }
                    @endphp

                    @if (count($attachments))
                        <div class="row">

                            @foreach ($attachments as $file)
                                @php
                                    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                @endphp

                                <div class="col-md-3 col-sm-6 mb-4">

                                    <div class="card border h-100 shadow-sm">

                                        @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                            <img src="{{ asset('storage/bill/attachment/' . $file) }}"
                                                class="card-img-top" style="height:220px;object-fit:cover;">
                                        @elseif($extension == 'pdf')
                                            <div class="text-center py-5">

                                                <i class="fa-solid fa-file-pdf fa-5x text-danger"></i>

                                                <p class="mt-3 mb-0 fw-bold">
                                                    PDF File
                                                </p>

                                            </div>
                                        @else
                                            <div class="text-center py-5">

                                                <i class="fa-solid fa-file fa-5x text-secondary"></i>

                                                <p class="mt-3 mb-0">
                                                    Attachment
                                                </p>

                                            </div>
                                        @endif

                                        <div class="card-footer text-center">

                                            <a href="{{ asset('storage/bill/attachment/' . $file) }}" target="_blank"
                                                class="btn btn-primary btn-sm">

                                                <i class="fa fa-eye"></i>
                                                View

                                            </a>

                                            <a href="{{ asset('storage/bill/attachment/' . $file) }}" download
                                                class="btn btn-success btn-sm">

                                                <i class="fa fa-download"></i>
                                                Download

                                            </a>

                                        </div>

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @else
                        <div class="alert alert-warning mb-0">

                            <i class="fa fa-exclamation-circle"></i>
                            No bill attachment has been uploaded.

                        </div>
                    @endif

                </div>

            </div> --}}

        </div>
    </section>

@endsection
