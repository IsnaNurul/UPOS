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


            @if ($status === true)
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
                                            <!-- New Step for Service Fee -->
                                            <div class="wizard-step" data-step="4">
                                                <div class="wizard-step-icon">
                                                    <i class="fas fa-cogs"></i>
                                                </div>
                                                <div class="wizard-step-label">
                                                    Service Fee
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
                                                    <input type="text" name="business_name" class="form-control"
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
                                                        class="btn btn-icon icon-right btn-primary">Next
                                                        <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- New Step 4: Service Fee -->
                                    <form action="{{ route('dashboard.store.service-fee') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="wizard-pane d-none" data-step-content="4">
                                            <div class="form-group row align-items-center">
                                                <label class="col-md-4 text-md-right text-left">Service Fee (%)</label>
                                                <div class="col-lg-4 col-md-6">
                                                    <input type="text" name="value" class="form-control" required>
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
                            {{-- <div class="change positive">+4.3% than last week</div> --}}
                        </div>
                    </div>
                </div>

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
                                                        {{ $product->stock }}
                                                    </td>
                                                    <td>
                                                        <div
                                                            class="badge {{ $product->stock == 0 ? 'badge-danger' : 'badge-warning' }}">
                                                            {{ $product->stock == 0 ? 'Out of Stock' : 'Low Stock' }}
                                                        </div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($product->last_stock_update)->format('M d, Y') }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary btn-icon" data-toggle="modal"
                                                            data-target="#updateStockModal" data-id="{{ $product->id }}"
                                                            data-stock="{{ $product->stock }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Daily Sales Chart with daily Filter --}}
                    <div class="col-12 col-md-6" style="width: 100%">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-header d-flex justify-content-between">
                                <h4>Daily Income</h4>
                                <div class="card-header-action d-flex">
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
                                            {{-- <th>Status Pembayaran</th> --}}
                                            <th class="text-center">Metode Pembayaran</th>
                                            {{-- <th>Sub Total Product</th> --}}
                                            <th>Diskon</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($lastTransactions as $transaction)
                                            <tr>
                                                <td class="font-weight-600">{{ $transaction->member->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($transaction->transactionTime)->format('d F Y - H:i') }}
                                                </td>
                                                <td>
                                                    <ul style="list-style: none; padding-left: 0;">
                                                        @if ($transaction->orderItems !== null)
                                                            @foreach ($transaction->orderItems as $item)
                                                                <li>{{ $item->product->name }} - Rp.
                                                                    {{ number_format($item->price, '0', ',', '.') }}</li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    <div
                                                        class="badge {{ $transaction->paymentMethod == 'cash' ? 'badge-success' : 'badge-primary' }}">
                                                        {{ $transaction->paymentMethod }}
                                                    </div>
                                                </td>
                                                @php
                                                    $discount =
                                                        $transaction->memberDiscount + $transaction->voucherDiscount;
                                                @endphp
                                                {{-- <td>Rp. {{ number_format($transaction->subTotal, '0', ',', '.') }}</td> --}}
                                                <td>Rp. {{ number_format($discount, '0', ',', '.') }}</td>
                                                <td>Rp. {{ number_format($transaction->totalPrice, '0', ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('order.show', $transaction->id) }}"
                                                        class="btn btn-primary btn-icon" data-toggle="tooltip"
                                                        data-placement="top" data-title="Detail Transaksi">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
        <!-- Update Stock Modal -->
        @if ($lowStockProducts !== null)
            <div class="modal fade" id="updateStockModal" tabindex="-1" role="dialog"
                aria-labelledby="updateStockLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateStockLabel">Update Stock</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="updateStockForm" action="{{ route('products.updateStock') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="productId" name="id">
                                <div class="form-group">
                                    <label for="stock">New Stock Quantity</label>
                                    <input type="number" id="stock" name="stock" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update Stock</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
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
                } else if (hash === '#step4') {
                    step = 4; // New step for Service Fee
                }

                // Hide all wizard steps
                document.querySelectorAll('.wizard-pane').forEach(function(pane) {
                    pane.classList.add('d-none');
                });

                // Show the selected step
                document.querySelector(`.wizard-pane[data-step-content="${step}"]`).classList.remove('d-none');

                // Update active step in navigation
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
        $('#updateStockModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var productId = button.data('id'); // Extract info from data-* attributes
            var stock = button.data('stock'); // Extract info from data-* attributes

            var modal = $(this);
            modal.find('#productId').val(productId); // Set the product ID in the modal input
            modal.find('#stock').val(stock); // Set the stock value in the modal input
        });
    </script>


    <script>
        function showUpdateStockModal(productId) {
            document.getElementById('productId').value = productId;
            $('#updateStockModal').modal('show');
        }
    </script>
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
                        'rgba(54, 162, 235, 0.2)', 'rgba(106, 232, 139, 0.5)',
                        'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)',
                    ],
                    borderColor: ['#36A2EB', '#6AE88B', '#9966FF', '#FF9F40'],
                    borderWidth: 2,
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
        const dailySalesData = @json($dailySales);
        const weeklySalesData = @json($weeklySales);
        const monthlySalesData = @json($monthlySales);
        const yearlySalesData = @json($yearlySales);

        // Daily Sales Chart
        function createDailySalesChart() {
            const ctx = document.getElementById("dailySalesChart").getContext('2d');

            const dateLabels = dailySalesData.map(sale => `Day ${sale.day}`);
            const salesData = dailySalesData.map(sale => sale.daily_sales);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'Penjualan Harian (IDR)',
                        data: salesData,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: '#36A2EB',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Hari'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Penjualan (IDR)'
                            }
                        }
                    }
                }
            });
        }

        // Weekly Sales Chart
        function createWeeklySalesChart() {
            const ctx = document.getElementById("weeklySalesChart").getContext('2d');

            const weekLabels = weeklySalesData.map(sale => `Minggu ${sale.week}`);
            const salesData = weeklySalesData.map(sale => sale.weekly_sales);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: weekLabels,
                    datasets: [{
                        label: 'Penjualan Mingguan (IDR)',
                        data: salesData,
                        backgroundColor: 'rgba(106, 232, 139, 0.5)',
                        borderColor: '#6AE88B',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Minggu'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Penjualan (IDR)'
                            }
                        }
                    }
                }
            });
        }

        // Monthly Sales Chart
        function createMonthlySalesChart() {
            const ctx = document.getElementById("monthlySalesChart").getContext('2d');

            const monthLabels = monthlySalesData.map(sale => `${sale.month}`);
            const salesData = monthlySalesData.map(sale => sale.monthly_sales);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Penjualan Bulanan (IDR)',
                        data: salesData,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: '#9966FF',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Penjualan (IDR)'
                            }
                        }
                    }
                }
            });
        }

        // Yearly Sales Chart
        function createYearlySalesChart() {
            const ctx = document.getElementById("yearlySalesChart").getContext('2d');

            const yearLabels = yearlySalesData.map(sale => `${sale.year}`);
            const salesData = yearlySalesData.map(sale => sale.yearly_sales);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: yearLabels,
                    datasets: [{
                        label: 'Penjualan Tahunan (IDR)',
                        data: salesData,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: '#FF9F40',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tahun'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Penjualan (IDR)'
                            }
                        }
                    }
                }
            });
        }

        // Initialize charts
        createDailySalesChart();
        createWeeklySalesChart();
        createMonthlySalesChart();
        createYearlySalesChart();
    </script>
@endpush
