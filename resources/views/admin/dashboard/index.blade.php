@extends('layouts.admin.master')

@section('title')
    Kidz Corner - Admin Dashboard
@endsection

@push('css_or_js')
    <style>
        /* Row hover effect */
        .product-row {
            transition: all 0.25s ease;
        }

        /* .product-row:hover {
            background: #f8faff;
            transform: scale(1.01);
        } */

        /* Product image */
        .product-img-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Profit badge */
        .profit-badge {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: #fff;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3);
        }

        /* Action buttons */
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f8f9fa;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: all 0.25s ease;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: #fff;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 18px rgba(79, 70, 229, 0.3);
        }

        .action-btn i {
            transition: 0.2s;
        }

        .action-btn:hover i {
            transform: rotate(-10deg);
        }

        /* Dropdown styling */
        .custom-dropdown {
            border-radius: 12px;
            padding: 8px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .custom-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 8px;
            padding: 8px 12px;
            transition: all 0.2s ease;
        }

        .custom-dropdown .dropdown-item:hover {
            background: #eef2ff;
            color: #4f46e5;
            transform: translateX(3px);
        }

        .custom-dropdown .text-danger:hover {
            background: #fff1f1;
            color: #dc3545;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Kidz Corner Dashboard</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Kidz Corner
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->


        </div>
        <!-- end container -->
    </section>
@endsection
@push('scripts')

@endpush
