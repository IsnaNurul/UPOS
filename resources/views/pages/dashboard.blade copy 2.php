@extends('layouts.app')

@section('title', 'Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <style>
        .d-none {
            display: none;
        }

        .card-summary {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card-summary:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 14px rgba(0, 0, 0, 0.2);
        }

        /* Card Summary start */
        .card-summary {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            border-bottom: 3px solid transparent;
            /* Ensure there's a bottom border */
        }

        .card-summary .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-summary .icon {
            font-size: 40px;
            /* Larger icon size */
            padding: 10px;
            /* Reduced padding so icon fits within container */
            width: 60px;
            height: 60px;
            /* Keep the container size the same */
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .card-summary .icon i {
            font-size: 30px;
            /* Increased size for the icon itself */
        }

        .card-summary.sales-today {
            border-bottom-color: #4f46e5;
            /* Indigo */
        }

        .card-summary.sales-month {
            border-bottom-color: #ea820c;
            /* Amber */
        }

        .card-summary.avg-sale {
            border-bottom-color: #07ae79;
            /* Green */
        }

        .card-summary.total-transactions {
            border-bottom-color: #de3232;
            /* Pink */
        }

        .card-summary .icon.sales-today {
            background-color: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
        }

        .card-summary .icon.sales-month {
            background-color: rgba(217, 119, 6, 0.1);
            color: #ea820c;
        }

        .card-summary .icon.avg-sale {
            background-color: rgba(5, 150, 105, 0.1);
            color: #07ae79;
        }

        .card-summary .icon.total-transactions {
            background-color: rgba(219, 39, 119, 0.1);
            color: #de3232;
        }

        /* Adjust number, description, and change text styles */
        .card-summary .number {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .card-summary .description {
            font-size: 16px;
            color: #666;
        }

        .card-summary .change {
            font-size: 14px;
            color: #666;
        }

        .card-summary .change.positive {
            color: #10b981;
            /* Green for positive change */
        }

        .card-summary .change.negative {
            color: #ef4444;
            /* Red for negative change */
        }

        /* Card summary end */

        /* start */
        .card-analysis {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            /* Ensure all cards are the same height */
        }

        .card-analysis .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .card-analysis .icon.chart {
            font-size: 30px;
            /* Size for the icon */
            padding: 10px;
            border-radius: 10px;
            color: #4f46e5;
            /* Color for icon */
        }

        #top-5-scroll {
            max-height: 300px;
            /* Sesuaikan tinggi maksimum sesuai kebutuhan */
            overflow-y: auto;
        }

        /* end */

        /* start */
        .stats-card {
            background-color: white;
            border-radius: 10px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
            padding: 20px;
            /* margin: 20px; */
        }

        .stats-card h5 {
            font-size: 1.25rem;
            color: #333;
        }

        .stats-card .stat-item {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .stats-card .stat-item .icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .stats-card .stat-item .icon i {
            font-size: 1.5rem;
        }

        .stats-card .stat-item .text {
            font-size: 1.25rem;
            color: #333;
        }

        .stats-card .stat-item .subtext {
            font-size: 0.875rem;
            color: #666;
        }

        .stats-card .updated {
            text-align: right;
            font-size: 0.875rem;
            color: #999;
        }

        .icon-sales {
            background-color: #e0e7ff;
            color: #6366f1;
        }

        .icon-customers {
            background-color: #cffafe;
            color: #06b6d4;
        }

        .icon-products {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .icon-revenue {
            background-color: #dcfce7;
            color: #22c55e;
        }

        /* end */
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            {{-- <div class="section-header">
                <h1>Dashboard</h1>
            </div> --}}

            @include('layouts.alert')


            @if ($status == true)
                {{-- Form Shipping --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Please complete the information below!</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mt-4">
                                    <div class="col-12 col-lg-8 offset-lg-2">
                                        <div class="wizard-steps">
                                            <div class="wizard-step wizard-step-active" data-step="1">
                                                <div class="wizard-step-icon">
                                                    <i class="far fa-user"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Profile Business
                                                </div>
                                            </div>
                                            <div class="wizard-step" data-step="2">
                                                <div class="wizard-step-icon">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Tax
                                                </div>
                                            </div>
                                            <div class="wizard-step" data-step="3">
                                                <div class="wizard-step-icon">
                                                    <i class="fas fa-wallet"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Payment Gateway
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="wizard-content mt-2" id="wizard-form">
                                    <form action="{{ route('dashboard.store.profile') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- Step 1: Profile Business -->
                                        <div class="wizard-pane" data-step-content="1">
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Business Name</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="bussiness_name" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Header</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="header_text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Footer</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="footer_text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label for="site-logo" class="col-md-4 text-md-right text-left">Logo</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="custom-file">
                                                        <input type="file" name="logo" class="custom-file-input"
                                                            id="site-logo" required>
                                                        <label class="custom-file-label" for="site-logo">Choose File</label>
                                                    </div>
                                                    <div class="form-text text-muted">The image must have a maximum size of
                                                        1MB</div>
                                                    @error('logo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4"></div>
                                                <div class="col-lg-4 col-md-6 text-right">
                                                    <button type="submit" class="btn btn-icon icon-right btn-primary"
                                                        id="next-step">Next <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Step 2: Tax -->
                                    <form action="{{ route('dashboard.store.tax') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="wizard-pane d-none" data-step-content="2">
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Type</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="type" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Value (%)</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="value" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4"></div>
                                                <div class="col-lg-4 col-md-6 text-right">
                                                    <button type="submit" class="btn btn-icon icon-right btn-primary">Next
                                                        <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- Step 3: Payment Gateway -->
                                    <form action="{{ route('dashboard.store.payment') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="wizard-pane d-none" data-step-content="3">
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Payment Gateway</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <select name="type_id" class="form-control" required>
                                                        <option value="" selected disabled>Select Type</option>
                                                        @foreach ($payment_gateaways as $item)
                                                            <option value="{{ $item->id }}">{{ $item->type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('type_id')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">API Key</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="api_key" class="form-control" required>
                                                    @error('api_key')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4"></div>
                                                <div class="col-lg-4 col-md-6 text-right">
                                                    <button type="submit"
                                                        class="btn btn-icon icon-right btn-primary">Submit <i
                                                            class="fas fa-check"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Sales Summary --}}
                <div class="row mb-5">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card-summary sales-today">
                            <div class="header">
                                <div class="icon sales-today">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="number">Rp. {{ number_format($todaySales, '0', ',', '.') }}</div>
                            </div>
                            <div class="description">Total Sales Today</div>
                            {{-- <div class="change positive">+18.2% than last week</div> --}}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card-summary sales-month">
                            <div class="header">
                                <div class="icon sales-month">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="number">Rp. {{ number_format($monthSales, '0', ',', '.') }}</div>
                            </div>
                            <div class="description">Total Sales This Month</div>
                            {{-- <div class="change negative">-8.7% than last week</div> --}}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card-summary avg-sale">
                            <div class="header">
                                <div class="icon avg-sale">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="number">Rp. {{ number_format($averageSale, '0', ',', '.') }}</div>
                            </div>
                            <div class="description">Average Sale/Transaction</div>
                            {{-- <div class="change positive">+4.3% than last week</div> --}}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card-summary total-transactions">
                            <div class="header">
                                <div class="icon total-transactions">
                                    <i class="fas fa-receipt"></i>
                                </div>
                                <div class="number">{{ $todayTransactions }}</div>
                            </div>
                            <div class="description">Total Transactions</div>
                            <div class="change positive">+4.3% than last week</div>
                        </div>
                    </div>
                </div>

                {{-- <div class="row mb-3" style="display: flex; align-items: stretch;">
                    <div class="col-md-4">
                        <div class="card" style="border-radius: 10px; height: 85%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 100%; padding: 20px; display: flex; align-items: flex-start; background-color: white; position: relative;">
                            <div class="content" style="margin-right: 140px; flex-grow: 1;">
                                <h5 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 5px;">Congratulations John! <i class="fas fa-party-popper"></i></h5>
                                <p style="margin: 0; color: #6c757d;">Best seller of the month</p>
                                <div class="price" style="font-size: 2rem; color: #7C40C4; margin: 10px 0;">$48.9k</div>
                            </div>
                            <img src="{{ asset('img/avatar/avatar-7.png') }}" width="35%" alt="" style="position:absolute; right: 1px; bottom: 1px;">
                        </div>
                    </div>
                
                    <div class="col-md-8">
                        <div style="background-color: #5768eb; height: 85%; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 20px; width: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <h2 style="margin: 0; font-size: 20px; color: #ffffff;">Statistics</h2>
                                <div style="font-size: 14px; color: #bbdefb;">Updated 1 month ago</div>
                            </div>
                            <div style="display: flex; justify-content: space-between; flex-grow: 1; margin-bottom: 20px;">
                                <!-- Sales -->
                                <div style="display: flex; align-items: center; padding: 10px; border-radius: 10px; text-align: start;">
                                    <i class="fas fa-chart-pie" style="font-size: 24px; margin-right: 10px; padding: 10px; background-color: #ffffff; border-radius: 10px; color: #a3a0fb; border: 2px solid #a3a0fb;"></i>
                                    <div>
                                        <div style="font-size: 14px; color: #ffffff;"><strong>Sales</strong></div>
                                        <div style="font-size: 18px; color: #ffffff;">Rp. 230.000</div>
                                    </div>
                                </div>
                                <!-- Customers -->
                                <div style="display: flex; align-items: center; padding: 10px; border-radius: 10px; text-align: start;">
                                    <i class="fas fa-users" style="font-size: 24px; margin-right: 10px; padding: 10px; background-color: #ffffff; border-radius: 10px; color: #00c9a7; border: 2px solid #00c9a7;"></i>
                                    <div>
                                        <div style="font-size: 14px; color: #ffffff;"><strong>Customers</strong></div>
                                        <div style="font-size: 18px; color: #ffffff;">8.549k</div>
                                    </div>
                                </div>
                                <!-- Products -->
                                <div style="display: flex; align-items: center; padding: 10px; border-radius: 10px; text-align: start;">
                                    <i class="fas fa-shopping-cart" style="font-size: 24px; margin-right: 10px; padding: 10px; background-color: #ffffff; border-radius: 10px; color: #ff6b6b; border: 2px solid #ff6b6b;"></i>
                                    <div>
                                        <div style="font-size: 14px; color: #ffffff;"><strong>Products</strong></div>
                                        <div style="font-size: 18px; color: #ffffff;">1.423k</div>
                                    </div>
                                </div>
                                <!-- Revenue -->
                                <div style="display: flex; align-items: center; padding: 10px; border-radius: 10px; text-align: start;">
                                    <i class="fas fa-wallet" style="font-size: 24px; margin-right: 10px; padding: 10px; background-color: #ffffff; border-radius: 10px; color: #4caf50; border: 2px solid #4caf50;"></i>
                                    <div>
                                        <div style="font-size: 14px; color: #ffffff;"><strong>Revenue</strong></div>
                                        <div style="font-size: 18px; color: #ffffff;">Rp. 2.500.000</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="row">
                    {{-- Top Selling Product Categories --}}
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-header">
                                <h4>Top Selling Product Categories</h4>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;">
                                    <div class="" style="width: 607px;">
                                        <!-- Set lebar agar chart lebih panjang -->
                                        <canvas id="myChart4"></canvas>
                                    </div>
                                </div> <!-- Aktifkan scroll horizontal -->
                            </div>
                        </div>
                    </div>

                    {{-- Top Selling Products --}}
                    <div class="col-12 col-md-3" style="width: 100%">
                        <div class="card gradient-bottom" style="border-radius: 15px;">
                            <div class="card-header">
                                <h4>Top Selling Products</h4>
                            </div>
                            <div class="card-body" id="top-5-scroll">
                                <ul class="list-unstyled list-unstyled-border">
                                    @foreach ($topSellingProducts as $product)
                                        <li class="media">
                                            <img class="mr-3 rounded" width="55"
                                                src="{{ asset('storage/public\products/' . ($product->product->image ?? 'default.png')) }}"
                                                alt="product">
                                            <div class="media-body">
                                                <div class="float-right">
                                                    <div class="font-weight-600 text-small">
                                                        <strong>{{ $product->total_sales }} Sales</strong>
                                                    </div>
                                                </div>
                                                <div class="media-title">{{ $product->product->name }}</div>
                                                <div class="mt-1">
                                                    <div class="budget-price">
                                                        <div class="budget-price-square bg-primary" data-width="5%"></div>
                                                        <div class="budget-price-label">Rp.
                                                            {{ number_format($product->product->price, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                    <div class="budget-price">
                                                        <div class="budget-price-square bg-danger" data-width="5%"></div>
                                                        <div class="budget-price-label">
                                                            {{ $product->product->category ?? 'Category' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer d-flex justify-content-center pt-3">
                                <div class="budget-price justify-content-center">
                                    <div class="budget-price-square bg-primary" data-width="20"></div>
                                    <div class="budget-price-label">Selling Price</div>
                                </div>
                                <div class="budget-price justify-content-center">
                                    <div class="budget-price-square bg-danger" data-width="20"></div>
                                    <div class="budget-price-label">Category</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- to members --}}
                    <div class="col-12 col-md-3" style="width: 100%">
                        <div class="card gradient-bottom" style="border-radius: 15px;">
                            <div class="card-header">
                                <h4>Top Members</h4>
                            </div>
                            <div class="card-body" id="top-5-scroll">
                                <ul class="list-unstyled list-unstyled-border">
                                    @foreach ($topMembers as $member)
                                        <li class="media">
                                            <img class="mr-3 rounded" width="55"
                                                src="https://static-00.iconduck.com/assets.00/avatar-icon-512x512-gu21ei4u.png"
                                                alt="customer">
                                            <div class="media-body">
                                                <div class="float-right">
                                                    <div class="font-weight-600 text-muted text-small">
                                                        {{ $member->purchase_count }} Purchases
                                                    </div>
                                                </div>
                                                <div class="media-title">{{ $member->name }}</div>
                                                <div class="mt-1">
                                                    <div class="budget-price">
                                                        <div class="budget-price-square bg-primary" data-width="5%"></div>
                                                        <div class="budget-price-label">Rp.
                                                            {{ number_format($member->total_purchase) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="card-footer d-flex justify-content-center pt-3">
                                <div class="budget-price justify-content-center">
                                    <div class="budget-price-square bg-primary" data-width="20"></div>
                                    <div class="budget-price-label">Purchase Amount</div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    {{-- Low Stock Products --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                            <div class="card-header">
                                <h4>Low Stock Products</h4>
                                {{-- <div class="card-header-action">
                                    <a href="#" class="btn btn-danger">View More <i
                                            class="fas fa-chevron-right"></i></a>
                                </div> --}}
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                                <th>Last Updated</th> <!-- Change Restock Date to Last Updated -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lowStockProducts as $product)
                                                <tr>
                                                    <td class="font-weight-600">{{ $product->name }}</td>
                                                    <td
                                                        class="{{ $product->stock == 0 ? 'text-danger' : 'text-warning' }}">
                                                        {{ $product->stock }} Units
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="badge {{ $product->stock == 0 ? 'badge-danger' : 'badge-warning' }}">
                                                            {{ $product->stock == 0 ? 'Out of Stock' : 'Low Stock' }}
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($product->updated_at)->format('M d, Y') }}
                                                    </td> <!-- Display updated_at -->
                                                    <td>
                                                        {{-- <a href='{{ route('product.edit', $product->id) }}'
                                                            class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                            data-placement="top" data-title="Update Stock">
                                                            <i class="fas fa-edit"></i>
                                                        </a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Earning Report --}}
                    {{-- <div class="col-12 col-md-5 col-lg-5 mb-4">
                        <div class="card-2 position-relative p-4"
                            style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">

                            <!-- Header and Earnings Summary -->
                            <h2 style="font-size: 18px; color: #333; margin: 0;">Earning Reports</h2>
                            <p style="font-size: 14px; color: #888; margin: 5px 0 20px;">Weekly Earnings Overview</p>
                            <div class="amount" style="font-size: 48px; font-weight: bold; color: #333;">$468</div>
                            <div class="percentage"
                                style="display: inline-block; background-color: #e0f7e9; color: #34c38f; padding: 5px 10px; border-radius: 5px; font-size: 14px; margin-top: 5px;">
                                +4.2%
                            </div>
                            <div class="info" style="font-size: 14px; color: #888; margin-top: 10px;">Compared to
                                last week</div>

                            <!-- Earnings, Profit, and Expense Summary -->
                            <div class="summary d-flex justify-content-between mt-3 mb-3">
                                <!-- Earnings -->
                                <div class="text-center">
                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            style="background-color: #7367f0; color: white; border-radius: 5px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                            <i class="fas fa-dollar-sign"></i>
                                        </div>
                                        <p style="margin: 0; font-size: 14px; color: #888;"><strong>Earnings</strong></p>
                                    </div>
                                    <div class="amount" style="font-size: 20px; color: #333;">Rp. 2.500.000</div>
                                    <div class="bar"
                                        style="height: 4px; border-radius: 2px; background-color: #7367f0; width: 100%; margin-top: 5px;">
                                    </div>
                                </div>

                                <!-- Profit -->
                                <div class="text-center">
                                    <div class="d-flex align-items-center mb-2">
                                        <div
                                            style="background-color: #34c38f; color: white; border-radius: 5px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <p style="margin: 0; font-size: 14px; color: #888;"><strong>Profit</strong></p>
                                    </div>
                                    <div class="amount" style="font-size: 20px; color: #333;">Rp. 2.500.000</div>
                                    <div class="bar"
                                        style="height: 4px; border-radius: 2px; background-color: #34c38f; width: 100%; margin-top: 5px;">
                                    </div>
                                </div>

                                <!-- Expense -->
                                <div class="text-center">
                                    <div class="d-flex align-items-center center mb-2">
                                        <div
                                            style="background-color: #f46a6a; color: white; border-radius: 5px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <p style="margin: 0; font-size: 14px; color: #888;"><strong>Expense</strong></p>
                                    </div>
                                    <div class="amount" style="font-size: 20px; color: #333;">Rp. 2.500.000</div>
                                    <div class="bar"
                                        style="height: 4px; border-radius: 2px; background-color: #f46a6a; width: 100%; margin-top: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- Daily Sales Chart with daily Filter --}}
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Daily Income</h4>
                                <div class="card-header-action d-flex">
                                    <select id="monthFilter" class="form-control" onchange="updateChart()">
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <!-- Add more months as needed -->
                                    </select>
                                    <select id="weekFilter" class="form-control ml-2" onchange="updateChart()">
                                        <option value="all">Full Month</option>
                                        <option value="1">Week 1</option>
                                        <option value="2">Week 2</option>
                                        <option value="3">Week 3</option>
                                        <option value="4">Week 4</option>
                                        <!-- Adjust if month has 5 weeks -->
                                    </select>
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;">
                                    <div style="min-width: 800px;">
                                        <canvas id="dailySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Weekly Sales Chart -->
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Weekly Sales</h4>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;">
                                    <div style="min-width: 800px;">
                                        <canvas id="weeklySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Monthly Sales Chart -->
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card mt-4" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Monthly Sales</h4>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;">
                                    <div style="min-width: 800px;">
                                        <canvas id="monthlySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Yearly Sales Chart -->
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card mt-4" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Yearly Sales</h4>
                            </div>
                            <div class="card-body">
                                <div style="overflow-x: auto;">
                                    <div style="min-width: 800px;">
                                        <canvas id="yearlySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Last Transactions --}}
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                            <div class="card-header">
                                <h4>Last Transactions</h4>
                                <div class="card-header-action">
                                    <a href="#" class="btn btn-danger">View More <i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Nama Pelanggan</th>
                                            <th>Tanggal</th>
                                            <th>Detail Produk</th>
                                            <th>Status Pembayaran</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Diskon</th>
                                            <th>Harga Produk</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-600">John Doe</td>
                                            <td>2024-10-30</td>
                                            <td>
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li>Produk A - Rp. 150.000</li>
                                                    <li>Produk B - Rp. 200.000</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="badge badge-success">Lunas</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-primary">Cash</div>
                                            </td>
                                            <td>10%</td>
                                            <td>Rp. 350.000</td>
                                            <td>Rp. 315.000</td> <!-- Total after discount -->
                                            <td>
                                                <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                    data-placement="top" data-title="Detail Transaksi">
                                                    <i class="fas fa-eye"></i> <!-- View Icon -->
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-600">Jane Smith</td>
                                            <td>2024-10-29</td>
                                            <td>
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li>Produk C - Rp. 300.000</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="badge badge-warning">Pending</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-secondary">Transfer</div>
                                            </td>
                                            <td>5%</td>
                                            <td>Rp. 300.000</td>
                                            <td>Rp. 285.000</td> <!-- Total after discount -->
                                            <td>
                                                <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                    data-placement="top" data-title="Detail Transaksi">
                                                    <i class="fas fa-eye"></i> <!-- View Icon -->
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-600">Michael Johnson</td>
                                            <td>2024-10-28</td>
                                            <td>
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li>Produk D - Rp. 180.000</li>
                                                    <li>Produk E - Rp. 200.000</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="badge badge-success">Lunas</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-primary">Cash</div>
                                            </td>
                                            <td>0%</td>
                                            <td>Rp. 370.000</td>
                                            <td>Rp. 370.000</td> <!-- Total after discount -->
                                            <td>
                                                <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                    data-placement="top" data-title="Detail Transaksi">
                                                    <i class="fas fa-eye"></i> <!-- View Icon -->
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-600">Emily Davis</td>
                                            <td>2024-10-27</td>
                                            <td>
                                                <ul style="list-style: none; padding-left: 0;">
                                                    <li>Produk F - Rp. 500.000</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="badge badge-danger">Batal</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-secondary">Transfer</div>
                                            </td>
                                            <td>15%</td>
                                            <td>Rp. 500.000</td>
                                            <td>Rp. 425.000</td> <!-- Total after discount -->
                                            <td>
                                                <a href="#" class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                    data-placement="top" data-title="Detail Transaksi">
                                                    <i class="fas fa-eye"></i> <!-- View Icon -->
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function showStepFromHash() {
                const hash = window.location.hash;
                let step = 1; // Default to step 1

                if (hash === '#step2') {
                    step = 2;
                } else if (hash === '#step3') {
                    step = 3;
                }

                document.querySelector(`.wizard-pane[data-step-content="1"]`).classList.toggle('d-none', step !==
                    1);
                document.querySelector(`.wizard-pane[data-step-content="2"]`).classList.toggle('d-none', step !==
                    2);
                document.querySelector(`.wizard-pane[data-step-content="3"]`).classList.toggle('d-none', step !==
                    3);

                document.querySelector('.wizard-step-active').classList.remove('wizard-step-active');
                document.querySelector(`.wizard-step[data-step="${step}"]`).classList.add('wizard-step-active');
            }

            showStepFromHash();
        });
    </script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        var ctx = document.getElementById("myChart4").getContext('2d');

        // Use the passed topCategories data
        var topCategories = @json(array_keys($topCategories));
        var totalSold = @json(array_values($topCategories));

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: topCategories,
                datasets: [{
                    data: totalSold,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                    ],
                    borderWidth: 1.5,
                    borderRadius: 5,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(1) + "%";
                                return `${label}: ${value} sold (${percentage})`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Categories',
                            color: '#666'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Quantity Sold',
                            color: '#666'
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1, // Set step size to 1 for whole numbers
                            precision: 0, // Prevents decimal places
                            font: {
                                family: 'Arial',
                                size: 12
                            },
                            color: '#666'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const dailySalesData = {
            '0': [200000, 300000, 400000, 250000, 350000, 450000, 300000, 500000, 600000, 550000, 400000, 300000,
                700000, 800000, 900000, 650000, 500000, 400000, 300000, 200000, 250000,
            ],
            // Add sales data for other months (1-11) as needed
            '1': [150000, 200000, 250000, 300000, 350000, 400000, 450000, 400000, 350000, 300000, 250000, 400000,
                450000, 500000, 600000, 550000, 500000, 400000, 300000, 200000, 300000, 400000, 500000, 600000,
                700000, 800000, 900000, 1000000, 950000, 850000, 700000, 600000
            ],
            '2': [100000, 150000, 200000, 250000, 300000, 350000],
            // Add sales data for March (2) through December (11)...
        };

        let dailySalesChart;

        function createChart(month, week) {
            const ctx = document.getElementById("dailySalesChart").getContext('2d');

            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            const currentDay = currentDate.getDate();
            const daysInMonth = new Date(currentYear, month + 1, 0).getDate();

            // Generate date labels for the current month
            let dateLabels = Array.from({
                length: daysInMonth
            }, (_, i) => `${i + 1} ${new Date(currentYear, month).toLocaleString('en-US', { month: 'short' })}`);

            // Filter data and labels up to the current day if the selected month is the current month
            let salesData = dailySalesData[month];
            if (month == currentMonth) {
                salesData = salesData.slice(0, currentDay); // Data up to today's date
                dateLabels = dateLabels.slice(0, currentDay); // Labels up to today's date
            }

            // Filter by week if a specific week is selected
            if (week !== 'all') {
                const startDay = (week - 1) * 7;
                const endDay = Math.min(startDay + 7, salesData.length);
                salesData = salesData.slice(startDay, endDay);
                dateLabels = dateLabels.slice(startDay, endDay);
            }

            dailySalesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'Penjualan (IDR)',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Light blue
                        borderColor: '#36A2EB', // Blue line
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    return `Penjualan: Rp ${value.toLocaleString()}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal',
                                color: '#666'
                            },
                            ticks: {
                                autoSkip: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Penjualan (IDR)',
                                color: '#666'
                            },
                            ticks: {
                                callback: function(value) {
                                    return `Rp ${value.toLocaleString()}`;
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateChart() {
            const selectedMonth = document.getElementById('monthFilter').value;
            const selectedWeek = document.getElementById('weekFilter').value;

            if (dailySalesChart) {
                dailySalesChart.destroy(); // Destroy the previous chart instance
            }

            // Create a new chart for the selected month and week
            createChart(selectedMonth, selectedWeek);
        }

        // Initial chart creation for January and full month
        createChart(0, 'all');

        const weeklySalesData = [ // Example weekly sales data for a month
            1500000, 2200000, 1700000, 2500000
        ];
        const monthlySalesData = [ // Example monthly sales data for a year
            5000000, 7500000, 6000000, 8500000, 9000000, 7200000, 10000000, 9500000, 8000000, 8500000, 9000000, 9500000
        ];
        const yearlySalesData = [ // Example yearly sales data for multiple years
            105000000, 112000000, 108500000, 115000000, 120000000
        ];

        function initializeWeeklyChart() {
            const ctx = document.getElementById("weeklySalesChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
                    datasets: [{
                        label: 'Weekly Sales (IDR)',
                        data: weeklySalesData,
                        backgroundColor: 'rgba(106, 232, 139, 0.5)', // Hijau transparan
                        borderColor: '#6AE88B', // Hijau lebih solid untuk border
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `Sales: Rp ${context.raw.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (IDR)'
                            }
                        }
                    }
                }
            });
        }

        function initializeMonthlyChart() {
            const ctx = document.getElementById("monthlySalesChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: 'Monthly Sales (IDR)',
                        data: monthlySalesData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: '#9966FF',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `Sales: Rp ${context.raw.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (IDR)'
                            }
                        }
                    }
                }
            });
        }

        function initializeYearlyChart() {
            const ctx = document.getElementById("yearlySalesChart").getContext("2d");
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["2020", "2021", "2022", "2023", "2024"], // Adjust as needed
                    datasets: [{
                        label: 'Yearly Sales (IDR)',
                        data: yearlySalesData,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: '#FF9F40',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: context => `Sales: Rp ${context.raw.toLocaleString()}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Sales (IDR)'
                            }
                        }
                    }
                }
            });
        }

        // Initialize all charts on page load
        initializeWeeklyChart();
        initializeMonthlyChart();
        initializeYearlyChart();
    </script>
@endpush
